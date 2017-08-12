<?php
if(!isset($_GET['model']))die('ff');
$model=$_GET['model'];
if(!isset($_GET['serial']))die('ff');
$serial=$_GET['serial'];

require 'cfg.php';
require 'SQLgen/SQLgen.php';

$connection = new PDO('mysql:host='.$db_host.';dbname='.$db_db.';charset=utf8', $db_user, $db_pass, array(PDO::ATTR_EMULATE_PREPARES => false,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$q = new SQLgen;
$q->selectCol1();
$q->addCSVcol("drive_erased");
$q->addCSVcol("smart_passed");
$q->selectCol2("disk_log");
$q->whereEquilTo("drive_model", $model);
$q->andEquilTo("drive_serial", $serial);
$q->andGreaterThanEquilToNQ("timestamp", "DATE_SUB(NOW(), INTERVAL 20 MINUTE)");
$q->orderBy("id", false);
$q->end();
$res = $connection->query($q->_buffer);
if($row = $res->fetch(PDO::FETCH_OBJ))
{
	if($row->drive_erased == 1)echo "p";
	else echo"f";
	if($row->smart_passed == 1)echo "s";
	else echo"e";
}
else
{
	echo "ff";
}