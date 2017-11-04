# gfgdf
Geeks 4 God Disk Wipe.   WARNING This program is capable of wipeing hard drives, Fast, and Permanently!


This expects your firewalls DNS server to have a entry called "gfgdfserver"  which goes to the IP of a standard linux apache server




The webinterface folder shuld end up at http://gfgdfserver/

EG http://gfgdfserver/gfgdf/dataSubmit.php 

gfgDiskWipe shuld be at http://gfgdfserver/gfgDiskWipe



http://gfgdfserver/gfgUpdater.txt is converted to php by the client and run to update the client,
You may use this for other things.

http://gfgdfserver/gfgdf/gfgDF.txt shuld be an exact copy of liveCD_src/gfgDF.php
This is how older boot cds get a updated runtime script automaticly.


http://gfgdfserver/gfgdf/disk_log.sql shuld be sourced on your server, and its location and auth shuld match http://gfgdfserver/gfgdf/cfg.php


To lookup results with a barcode scanner.
http://gfgdfserver/gfgdf/lookup.php

To use the ZXing android barcode scanner app,  Use this as a custom search URL.
http://gfgdfserver/gfgdf/lookup.php?serial=%s



Why is it called GFG Disk Fix?

Geeks 4 God a Group that is a part of the United Methodist Church of the Resurrection, in Leewood, KS. Providing computers, IT equipment and IT service for non profits in the KC metro, and world wide.
Disk Fix because it permanently "Fixes" any windows installation, The windows Virus/Install can't surivive :p