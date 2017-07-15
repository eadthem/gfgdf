<?php
include 'cfg.php';
include 'SQLgen/SQLgen.php';


function getMac()
{
	$ip=$_SERVER['REMOTE_ADDR'];
	$mac_string = shell_exec("arp -a $ip");
	$mac_array = explode(" ",$mac_string);
	$mac = $mac_array[3];
	return $mac;
}

echo"file upload
";
//if they DID upload a file...
if($_FILES['log']['name'])
{
	//if no errors...
	if(!$_FILES['log']['error'])
	{
		$valid_file = true;
		//now is the time to modify the future file name and validate the file
		$new_file_name = strtolower($_FILES['log']['name']); //rename file
		if($_FILES['log']['size'] > (24000)) //can't be larger than 24Kb
		{
			$valid_file = false;
			$message = 'Oops!  Your file\'s size is to large.';
		}

		//if the file has passed the test
		if($valid_file)
		{
			$contents="";
			//move it to where we want it to be
			//move_uploaded_file($_FILES['log']['tmp_name'], '/srv/www/htdocs/gfgdf/uploads/'.$new_file_name);
			$file = fopen($_FILES['log']['tmp_name'], "r") or exit("Unable to open file!");
			//Output a line of the file until the end is reached
			if($file != false)
			{
				$driveErased = false;
				$model = "";
				$serial = "";
				$smartResult = false;
				while(!feof($file))
				{
					$thisLine = strtolower(trim(fgets($file)));
					echo 'FILELINE=:'.$thisLine.":
" ;
					$contents .= $thisLine;
					//substr($string, 0, strlen($query)) === $query
					//$passed = "===== passed,  drive erased.  passed";
					if(strpos($thisLine, 'passed,  drive erased') !== false)
					{
						$driveErased = true;
					}
					else
					{
						$data = explode(":", $thisLine);
						
						if($data[0] === "device model" || $data[0] == "product")
						{
							$model = trim($data[1]);
						}
						elseif($data[0] === "serial number")
						{
							$serial = trim($data[1]);
						}
						elseif($data[0] === "smart overall-health self-assessment test result")								
						{
							if(trim($data[1]) === "passed")
							{
								$smartResult = true;
							}
						}
						elseif($data[0] == "smart health status")
						{
							if(trim($data[1]) == "ok")
							{
								$smartResult = true;
							}
						}
					}
					/*
					 * ===== passed,  drive erased. v.6.25  passed: in 302 min, 52 mbps =====
					 * device model:     toshiba mk5056gsy
					 * serial number:    10hyt558t
					 * smart overall-health self-assessment test result: passed
					 */
					
					
					
				}
				fclose($file);
				
				if(!empty($model) && !empty($serial))
				{
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
					$q->insertPartialVALUES();
					$q->addCSVAutoincrment();
					$q->addCSVCurrentTimestamp();
					if($driveErased == true )$q->addCSVvalue("1");
					if($driveErased == false )$q->addCSVvalue("0");
					if($smartResult == true )$q->addCSVvalue("1");
					if($smartResult == false )$q->addCSVvalue("0");					
					$q->addCSVvalue($model);
					$q->addCSVvalue($serial);
					$q->addCSVvalue($_SERVER['REMOTE_ADDR']);
					$q->addCSVvalue(getMac());
					$q->addCSVvalue($contents);
					$q->enddbg();
					$connection->query($q->_buffer);
				
				}
				
				$message = 'Congratulations!  Your file was accepted.';
			}
		}
	}
	//if there is an error...
	else
	{
		//set that to be the returned message
		$message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['photo']['error'];
	}
}
/*
//you get the following information for each file:
$_FILES['field_name']['name']
$_FILES['field_name']['size']
$_FILES['field_name']['type']
$_FILES['field_name']['tmp_name']
*/
?>
