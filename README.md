# **_PHP Stream Sniper_**
> Using PHP to bypass Free streaming restrictions on Broadcastify and Caster FM.

----
### BROADCASTIFY   
> Broadcastify streams are direct and require nothing more than the streaming link.    
### CASTER FM   
> Caster FM ( caster.fm ) links are a little more tedious as they require a registration for the premium account to get a direct streaming link, the way to bypass this is fairly simple and work's on many websites, but is sometimes seen as cross-site scripting or a denial of service to the websites premium features, it's always good to add some attributes to the provider at least.  
> To bypass a caster.fm stream, we need to request the Free Widget link to the stream and then extract the Authentication Token and Port number to the direct stream, once obtained - the script will start a passthrough of the streams live bytes back to the user as an mpeg stream of bytes. Pretty simple 🤔






