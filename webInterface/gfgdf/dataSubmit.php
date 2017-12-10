<?php

function getMac()
{
	$ip=$_SERVER['REMOTE_ADDR'];
	$mac_string = shell_exec("arp -a $ip");
	echo $mac_string;
	$mac_array = explode(" ",$mac_string);
	$mac = $mac_array[3];
	return $mac;
}

/*
	/gfgdf/dataSubmit.php?
	family=e&
	model=eVBOX HARDDISK&
	serial=eVBb54377e7426d2acc&
	size=e80gb&
	reallocSectCount=e&
	uncorrectCount=e&
	reallocEventCount=e&
	CurrentPendingCount=e&
	offlineUncorrectCount=e&
	crc=4118608186
	
	http://192.168.1.3/gfgdf/dataSubmit.php?family=pWestern+Digital+VelociRaptor&model=pWDC+WD800HLFS75G6U0&serial=pWDWXL908030244&size=p80.0+GB&reallocSectCount=pV%3D200W%3D200R%3D0&uncorrectCount=p&reallocEventCount=pV%3D200W%3D200R%3D0&CurrentPendingCount=pV%3D200W%3D200R%3D0&offlineUncorrectCount=pV%3D200W%3D200R%3D0&crc=2981178253
*/

$_family=$_GET['family'];
if(!isset($_GET['family']))die('Format Error');
$_model=$_GET['model'];
if(!isset($_GET['model']))die('Format Error');
$_serial=$_GET['serial'];
if(!isset($_GET['serial']))die('Format Error');
$_size=$_GET['size'];
if(!isset($_GET['size']))die('Format Error');
$_reallocSectCount=$_GET['reallocSectCount'];
if(!isset($_GET['reallocSectCount']))die('Format Error');
$_uncorrectCount=$_GET['uncorrectCount'];
if(!isset($_GET['uncorrectCount']))die('Format Error');
$_reallocEventCount=$_GET['reallocEventCount'];
if(!isset($_GET['reallocEventCount']))die('Format Error');
$_CurrentPendingCount=$_GET['CurrentPendingCount'];
if(!isset($_GET['CurrentPendingCount']))die('Format Error');
$_offlineUncorrectCount=$_GET['offlineUncorrectCount'];
if(!isset($_GET['offlineUncorrectCount']))die('Format Error');
$crc=$_GET['crc'];
if(!isset($_GET['crc']))die('Format Error');
$speed = "";
if(!isset($_GET['speed']))$speed=$_GET['speed'];


$_family_code = substr($_family, 0,2);
$_model_code = substr($_model, 0,2);
$_serial_code = substr($_serial, 0,2);
$_size_code = substr($_size, 0,2);
$_reallocSectCount_code = substr($_reallocSectCount, 0,2);
$_uncorrectCount_code = substr($_uncorrectCount, 0,2);
$_reallocEventCount_code = substr($_reallocEventCount, 0,2);
$_CurrentPendingCount_code = substr($_CurrentPendingCount, 0,2);
$_offlineUncorrectCount_code = substr($_offlineUncorrectCount, 0,2);


$contents="";
//state   ps   Pass erase  Pass Smart
//state   fe   not Erased  smart error
if(
		$_model_code === $_family_code &&
		$_serial_code === $_family_code &&
		$_size_code === $_family_code &&
		$_reallocSectCount_code === $_family_code &&
		$_uncorrectCount_code === $_family_code &&
		$_reallocEventCount_code === $_family_code &&
		$_CurrentPendingCount_code === $_family_code &&
		$_offlineUncorrectCount_code === $_family_code
)
{
	$eraseState = substr($_model_code, 0,1);
	$smartState = substr($_model_code, 1,2);	
}
else
{
	$contents .= 'Format Error';
}
if($eraseState === 'p')$contents .="Erased ";
else $contents .="Cant Wipe ";
if($smartState === 's')$contents .="Smart Passed";
else $contents .="Drive Failing";

$family = substr($_family, 2);
$model = substr($_model, 2);
$serial = substr($_serial, 2);
$size = substr($_size, 2);
$reallocSectCount = urldecode(substr($_reallocSectCount, 2));
$uncorrectCount = urldecode(substr($_uncorrectCount, 2));
$reallocEventCount = urldecode(substr($_reallocEventCount, 2));
$CurrentPendingCount = urldecode(substr($_CurrentPendingCount, 2));
$offlineUncorrectCount = urldecode(substr($_offlineUncorrectCount, 2));


/*http://192.168.1.3/gfgdf/dataSubmit.php?
family=psWestern+Digital+VelociRaptor&
model=psWDC+WD800HLFS75G6U0&
serial=psWDWXL908030244&
size=ps80.0+GB&
reallocSectCount=psV%253D200W%253D200R%253D0&
uncorrectCount=ps&
reallocEventCount=psV%253D200W%253D200R%253D0&
CurrentPendingCount=psV%253D200W%253D200R%253D0&
offlineUncorrectCount=psV%253D200W%253D200R%253D0&
crc=3417122026

*/

//echo strtolower($state.trim($family).trim($model).trim($serial).trim($size));
echo 'calc ='.crc32(strtolower($eraseState.$smartState.trim($family).trim($model).trim($serial).trim($size))).'<br>'.PHP_EOL;
echo 'remt ='.$crc.'<br>'.PHP_EOL;

require 'cfg.php';
require 'SQLgen/SQLgen.php';

$connection = new PDO('mysql:host='.$db_host.';dbname='.$db_db.';charset=utf8', $db_user, $db_pass, array(PDO::ATTR_EMULATE_PREPARES => false,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$q = new SQLgen;
$q->insertPartialINSERT("disk_log");
$q->addCSVcol("id");
$q->addCSVcol("timestamp");
$q->addCSVcol("drive_erased");
$q->addCSVcol("smart_passed");
$q->addCSVcol("drive_model");
$q->addCSVcol("drive_serial");
$q->addCSVcol("station_ip");
$q->addCSVcol("station_mac");
$q->addCSVcol("note");
$q->addCSVcol("family");
$q->addCSVcol("size");
$q->addCSVcol("reallocatedSectCount");
$q->addCSVcol("uncorrectableSectCount");
$q->addCSVcol("reallocatedEventCount");
$q->addCSVcol("currentPendingSectCount");
$q->addCSVcol("offlineUncorrectableCount");
$q->addCSVcol("diskTestSpeedMBps");
$q->insertPartialVALUES();
$q->addCSVAutoincrment();
$q->addCSVCurrentTimestamp();
if($eraseState == "p"  )$q->addCSVvalue("1");//erased
else$q->addCSVvalue("0");
if($smartState == "s" )$q->addCSVvalue("1");//smart
else$q->addCSVvalue("0");
$q->addCSVvalue($model);
$q->addCSVvalue($serial);
$q->addCSVvalue($_SERVER['REMOTE_ADDR']);
$q->addCSVvalue(getMac());
$q->addCSVvalue($contents);
$q->addCSVvalue($family);//$q->addCSVcol("family");
$q->addCSVvalue($size);//$q->addCSVcol("size");
$q->addCSVvalue($reallocSectCount);//$q->addCSVcol("reallocatedSectCount");
$q->addCSVvalue($uncorrectCount);//$q->addCSVcol("uncorrectableSectCount");
$q->addCSVvalue($reallocEventCount);//$q->addCSVcol("reallocatedEventCount");
$q->addCSVvalue($CurrentPendingCount);//$q->addCSVcol("currentPendingSectCount");
$q->addCSVvalue($offlineUncorrectCount);//$q->addCSVcol("offlineUncorrectableCount");
$q->addCSVvalue($speed);
$q->enddbg();
$connection->query($q->_buffer);


