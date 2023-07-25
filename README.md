# **_PHP Stream Sniper_**
> Using PHP to bypass Free streaming restrictions on Broadcastify and Caster FM.

----
### BROADCASTIFY   
> Broadcastify streams are direct and require nothing more than the streaming link.    
### CASTER FM   
> To bypass a caster.fm stream, we need to request the Free Widget link to the stream and then extract the Authentication Token and Port number to the direct stream, once obtained - the script will start a passthrough of the streams bytes to the client . Pretty simple 🤔.
   
  
### Example Supported Links,   
_Broadcastify_    
```
https://broadcastify.cdnstream1.com/35239
```   
_Caster FM_   
```   
https://www.caster.fm/widgets/em_player.php?jsinit=true&uid=541413&t=green&c=&pop=true
```   
_Other Direct Streams_   
```   
https://s1-fmt2.liveatc.net/ymhb2.mp3?nocache=2022073007371612963
```   


Example usages,  
Direct HTML5 Audio link,    
```
https://your.site/stream.php?stream=https%3A%2F%2Fwww.caster.fm%2Fwidgets%2Fem_player.php%3Fjsinit%3Dtrue%26uid%3D541413%26t%3Dblue%26c%3D%26pop%3Dtrue
```
    
Example in HTML,   
```
<audio controls>
  <source src="/stream.php?stream=https%3A%2F%2Fwww.caster.fm%2Fwidgets%2Fem_player.php%3Fjsinit%3Dtrue%26uid%3D541413%26t%3Dblue%26c%3D%26pop%3Dtr" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
```


