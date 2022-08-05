<?php
// Set Timezone 
date_default_timezone_set("Australia/Brisbane");
$now = date("Y-m-d h:i:sa");   

// Get CloudFlare Connecting Client IP or Client IP otherwise.
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

// Get User Agent and IP for Client Mocking in Curl 
$agent = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];


// Get Stream URL Desired by website 
$url = urldecode($_GET["stream"]);


// Stream Provider Overrides 
// Caster FM
/**
Caster FM only allows direct streams to paying customers, we need to grab the port number and authentication token then read the bytes back to the user with mpeg headers flushing the bytes as they come in from the stream...
 
Notes,
some more work is needed to erase the audio as it gets streamed to the user, or else they're technically downloading the stream, not playing it - refreshing the browser window will start the stream back at the beginning like a downloaded audio file.
**/

if(strpos($url, "caster.fm") !== null)
{
 // Caster Widget URL Found, Getting Auth Token as Client
//
 $data = extractAuthSimple($url);
 $port = $data[0];
 $token = $data[1];
 $gen= "http://shaincast.caster.fm:".$port."/listen.mp3?".$token;

 $url = $gen;
}

// Broadcastify link is direct, nothing needed here - useless function.
if(strpos($url, "broadcastify") !== null)
{
// URL is Direct stream
$url = $url;
}

// Other Providers Assumed Direct Stream, using provided link and reading stream bytes back to Client.

stream($url);



// Functions,

// Stream Sniper
function stream($url, $mime = "audio/mpeg", $bufferSize = 1024*1024)
{
    header('Content-type: '.$mime);
    header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('Keep-Alive: timeout='.(60*24).', max='.(60*48));
    $handle = fopen($url, 'rb');

    ob_start();
    $bytes = '';
     $stream = true;
    while ($stream) {
        $bytes = fread($handle, $bufferSize);
        // BYTE CONTROL HERE, LET'S PASS BYTES DIRECTLY AND USE KEEP ALIVE HEADERS.
        echo $bytes;
        flush_buffers();

      }
  $status = fclose($handle);
  ob_end_flush(); 
}


// buffer flusher
function flush_buffers(){

    ob_flush();
    flush();

}


// Auth token extraction
function extractAuthSimple($url)
{
   $html = getPage($url);
   $keyToken = "&port=";
   $keyEndChar = "&type";
   $keyStart = strpos($html, $keyToken)+strlen($keyToken);
   $keyEnd = strpos($html, $keyEndChar, $keyStart);
   $keyLength = $keyEnd-$keyStart;
   $keyExtract = substr($html,$keyStart,$keyLength);
   return explode("&auth=",$keyExtract);
}


// typical get request with curl
function getPage($url, $asClient = true)
{
  $ch = curl_init();
if($asClient)
{
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
    curl_setopt ($ch, CURLOPT_USERAGENT, $agent);
}
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec ($ch);
     curl_close ($ch);
   return $data;
}
?>
