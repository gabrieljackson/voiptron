VoIP Tron!

Version: 0.4


--- Description ---

VoIP Tron is a web-based data formatter used to create various VoIP-setup related scripts and importable files.


--- Installation ---

1. Place files on a web server running PHP.
2. Download Bootstrap 2.3.2 from http://getbootstrap.com/2.3.2/ and unpack it to the root VoIP Tron directory.
3. Create voice.xml file in VOIPTRONROOT/config/voice.xml
4. Go to index.php in a respectable web browser.
5. ???
6. Profit!


--- Configuration ---

Version 0.4 introduces basic configuration options.

Call manager node IPs should now be entered into a voice.xml file at ./config/voice.xml
evg.php will pull these IPs to create the proper dial peers.


The following is a basic voice.xml template:

<?xml version="1.0" encoding="ISO-8859-1"?>
<data>
  <voice_services>
    <cucm>
      <ip>1.2.3.44</ip>
      <ip>1.2.3.45</ip>
      <ip>1.2.3.46</ip>
    </cucm>
  </voice_services>
</data>