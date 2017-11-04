<!DOCTYPE html>
<html>
<head>
	<title>Title of the document</title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="get">
<input type="text" name="serial" autofocus="autofocus" id="serial" />
</form>
<?php

if(!isset($_GET['serial']))die('ff');
$serial=$_GET['serial'];

require 'cfg.php';
require 'SQLgen/SQLgen.php';
global $connection;
$connection = new PDO('mysql:host='.$db_host.';dbname='.$db_db.';charset=utf8', $db_user, $db_pass, array(PDO::ATTR_EMULATE_PREPARES => false,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
function getResults($conn,$sn)
{
	$q = new SQLgen;
	$q->selectCol1();
	
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
	
	$q->selectCol2("disk_log");
	$q->whereLike("drive_serial", "%".$sn."%");
	//$q->andGreaterThanEquilToNQ("timestamp", "DATE_SUB(NOW(), INTERVAL 20 MINUTE)");
	$q->orderBy("id", false);
	$q->limit(30);
	$q->end();
	$count = 0;
	$res = $conn->query($q->_buffer);
	if ($res->rowCount() > 0)
	{
		echo '<table>';
		echo '<tr>';
		echo '<td>Erased</td>';
		echo '<td>Health</td>';
		echo '<td>Make</td>';
		echo '<td>Model</td>';
		echo '<td>Serial</td>';
		echo '<td>Size</td>';
		echo '<td>station</td>';
		echo '<td>timestamp</td>';
		echo '<td>Realc Sec #</td>';
		echo '<td>Uncor Sec #</td>';
		echo '<td>Realc Evn #</td>';
		echo '<td>Currn Pen #</td>';
		echo '<td>Offln Unc #</td>';
		echo '</tr>';
	}	
	while($row = $res->fetch(PDO::FETCH_OBJ))
	{
		$count++;
		$color="60PBlue.png";
		if($row->smart_passed == 1 && $row->drive_erased == 1)
		{
			if($count == 1)
			{
				echo '<audio autoplay>
				<source src="Ding.wav" type="audio/wav">
				</audio>';
			}
			$color="60PGreen.png";
		}
		else
		{
			if($count == 1)
			{
				echo '<audio autoplay>
				<source src="ringout.wav" type="audio/wav">
				</audio>';
			}
		}
	
		if($row->smart_passed == 1);
		else $color="60Porange.png";
		if($row->drive_erased == 1);
		else $color="60Pred.png";
		
		echo '<tr>';
		
		echo '<td background="'.$color.'">';
		if($row->drive_erased == 1)echo "Erased";
		else echo"!!CONTAINS DATA!!<br>NOT ERASED";
		echo '</td><td>';
		if($row->smart_passed == 1)echo "Health OK";
		else echo"SMART FAILURE<br>HEALTH BELOW THRESHOLD!";
		echo '</td>';
		echo '<td background="'.$color.'">'.$row->family.'</td>';
		echo '<td background="'.$color.'">'.$row->drive_model.'</td>';
		echo '<td background="'.$color.'">'.$row->drive_serial.'</td>';
		echo '<td background="'.$color.'">'.$row->size.'</td>';
		echo '<td background="'.$color.'">'.$row->station_mac.'</td>';
		echo '<td background="'.$color.'">'.$row->timestamp.'</td>';
		echo '<td background="'.$color.'">'.$row->reallocatedSectCount.'</td>';
		echo '<td background="'.$color.'">'.$row->uncorrectableSectCount.'</td>';
		echo '<td background="'.$color.'">'.$row->reallocatedEventCount.'</td>';
		echo '<td background="'.$color.'">'.$row->currentPendingSectCount.'</td>';
		echo '<td background="'.$color.'">'.$row->offlineUncorrectableCount.'</td>';
		
		echo '</tr>';
	}
	if($count > 0) echo '</table>';
	return $count;
}

$ret = getResults($connection, $serial);
if($ret == 0)
{
	$ret = getResults($connection, substr($serial,6)); //Handle HGST modesl with extra 6 digit prefix in barcode only.
}
if($ret == 0)
{
	$ret = getResults($connection, substr($serial,0, -3)); //Handle Toshiba modesl with 3 extra characters at end of serial in barcode only.
}

if($ret == 0)
{
	echo'<font size="5" bgcolor="red">NO DRIVE FOUND</font>';
}

?>
</body>
</html>
