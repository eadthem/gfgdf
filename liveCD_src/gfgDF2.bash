#!/bin/bash
#sleep 5

#chvt 1


clear


echo "=== Geeks 4 God - United Methodist Church of the Resurrection ==="
echo "=== DISK KILL AND TEST.  SECURE DRIVE ERASE. 06-25-2016==="
echo ""
echo "No warrenty given,  This may not work. And its not our fault!"
echo ""
echo "Network Status"
ifconfig
echo ""
echo "WARNING WARNING WARNING"
echo "This program will erase all detected hard drives. Permanently!"
echo "Press Y to continue. [No] "
read -n1 response
echo ""
if [[ $response != "Y" ]] ; then
	echo "Disks not wiped. User canciled or didnt use an uppercase Y."
	echo ""
	echo "type  gfgDF.bash to rerun."
	exit 0;
fi




cd /dev
for f in sd? ; do
	clear
	echo "=== Geeks 4 God - United Methodist Church of the Resurrection ==="
	echo "=== DISK KILL AND TEST.  SECURE DRIVE ERASE. 06-25-2016==="
	echo " "
	echo "This disk will be wiped,  Listing all disks before last chance to abort."
	echo "$(smartctl -i /dev/$f -i | grep "Device Model")"
	echo "$(smartctl -i /dev/$f -i | grep "Serial Number")"
	echo " "
	fdisk -l /dev/$f
	echo " "
	echo "Any Key to see next drive."
	read -n1 response
	
done

clear

echo "=== Geeks 4 God - United Methodist Church of the Resurrection ==="
echo "=== DISK KILL AND TEST.  SECURE DRIVE ERASE. 06-25-2016==="
echo ""
echo "WARNING WARNING WARNING"
echo "LET ME ASK YOU AGAIN.   I AM ABOUT TO ERASE ALL YOUR DATA!"
echo "Type >Yes< to continue, then hit enter. [No] "
read response

if [[ $response != "Yes" ]] ; then
	echo "Disks not wiped. User cancled or didnt use an uppercase Y."
	echo ""
	echo "type  gfgDF.bash to rerun."
	exit 0;
fi
echo ""


clear
wipeDisk()
{
	echo " wipeing /dev/$1"
	echo "hdparm Erase" >> /tmp/diskOut$1
	hdparm --user-master u --security-set-pass erase /dev/sdx
	hdparm --user-master u --security-erase erase /dev/sdx >> /tmp/diskOut$1
	hdparm --user-master u --security-unlock p /dev/sdx
	hdparm --user-master u --security-disable p /dev/sdx
	rm /tmp/diskOut$1
	echo "hdparm Erase Done" >> /tmp/diskOut$1


	#fdisk -l /dev/$1

	gfgDiskWipe /dev/$1

	sleep 2
	
	touch /tmp/diskDone$1

	echo "Random Data & Zero Wipe Done $1  Starting SMART tests Disk." >> /tmp/diskOut$1
	

	smartctl /dev/$1 -t short
	
	echo "Wipe Done $1  Testing Disk. 2 min short self test..." >> /tmp/diskOut$1

	sleep 180
	
	echo "Wipe Done $1  Testing Wipe, Disk Test results ready." >> /tmp/diskOut$1
	
	
	
	
	
	
	#echo "===DISK DONE /dev/$1 ==="
	smartctl -i /dev/$1 -i | grep -i "Device Model\|Product" >> "/tmp/diskDone$1"
	smartctl -i /dev/$1 -i | grep -i "Serial Number" >> "/tmp/diskDone$1"
	smartctl /dev/$1 -H | grep -i -m 1 'result\|fail\|unavailable\|error' &>> "/tmp/diskDone$1"

	echo "Wipe Done $1  Disk Test Done." > /tmp/diskOut$1
	smartctl /dev/$1 -H | grep -i -m 1 'result\|fail\|unavailable\|error' &>> "/tmp/diskOut$1"
	
	curl --form "log=@/tmp/diskDone$1" "http://gfgdfserver/gfgdf/index.php"
	
	rm "/tmp/diskStart$1"
	exit 0
}




if [[ $response == "Yes" ]]; then

	cd /dev
	for f in sd? ; do
		touch /tmp/diskStart$f
	
		echo " touch"
		wipeDisk $f &
		echo " "
		echo " "
	done
	echo ""
	echo "===================="
	echo ""
	#ls /tmp
	while true;do
		clear
		words=`ls /tmp/diskStart* |wc -l`;
		#echo "Words = $words"
		if [[ $words == 0 ]]; then
			#ls /tmp
			#echo "break"
			break
		else
			#ls /tmp
			echo "=== Geeks 4 God - United Methodist Church of the Resurrection b.06-25-2016==="
			 echo "ERASEING with AES256 PRNG Random Data, Zeroing, Then running SMART Tests."
		fi
	
	
		for f in sd? ; do
			echo " "
			echo "Disk $f  \\/"
			tail -n 1 /tmp/diskOut$f
		
		done
		sleep 2
	done

	clear
	echo "========WIPE DONE  Listing finished disks. Build.06-25-2016========"

	cd /tmp
	for d in diskDone* ; do
		cat $d
		#echo " "
	done
	echo "press Control C to end notice"
	for (( c=1; c<=100; c++ ))
	do
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 0
		echo -en "\007"
		sleep 1
		
	done
	echo "done"

fi
