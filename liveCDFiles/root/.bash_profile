cd /usr/sbin
echo "Waiting for network to go live....  15 Sec"
sleep 15
echo "Checking for updates."
curl -O http://gfgdfserver/gfgUpdater.txt -o gfgUpdater.txt
mv gfgUpdater.txt gfgUpdater.php
php gfgUpdater.php
cd ~
php /usr/sbin/gfgDF.php
