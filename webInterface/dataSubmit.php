<?php
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



$_family_code = substr($_family, 0,1);
$_model_code = substr($_model, 0,1);
$_serial_code = substr($_serial, 0,1);
$_size_code = substr($_size, 0,1);
$_reallocSectCount_code = substr($_reallocSectCount, 0,1);
$_uncorrectCount_code = substr($_uncorrectCount, 0,1);
$_reallocEventCount_code = substr($_reallocEventCount, 0,1);
$_CurrentPendingCount_code = substr($_CurrentPendingCount, 0,1);
$_offlineUncorrectCount_code = substr($_offlineUncorrectCount, 0,1);
if($_family_code === 'e' &&
		$_model_code === 'e' &&
		$_serial_code === 'e' &&
		$_size_code === 'e' &&
		$_reallocSectCount_code === 'e' &&
		$_uncorrectCount_code === 'e' &&
		$_reallocEventCount_code === 'e' &&
		$_CurrentPendingCount_code === 'e' &&
		$_offlineUncorrectCount_code === 'e'
)
{
	$state = 'e';
}
else
{
	$state = 'f';
}

$family = substr($_family, 1);
$model = substr($_model, 1);
$serial = substr($_serial, 1);
$size = substr($_size, 1);
$reallocSectCount = substr($_reallocSectCount, 1);
$uncorrectCount = substr($_uncorrectCount, 1);
$reallocEventCount = substr($_reallocEventCount, 1);
$CurrentPendingCount = substr($_CurrentPendingCount, 1);
$offlineUncorrectCount = substr($_offlineUncorrectCount, 1);




echo 'calc ='.crc32(strtolower($state.$family.$model.$serial.$size)).'<br>'.PHP_EOL;
echo 'remt ='.$crc.'<br>'.PHP_EOL;