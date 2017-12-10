#!/usr/bin/php
<?php
//unit tests
function stringIsInString($haystack,$needle)
{
	if(strpos($haystack, $needle) !== false) return true;
	return false;
}
{
	$UT_family = "Hitachi Travelstar 7K500";
	if(stringIsInString($UT_family, "7K500"));
	else die("UnitTest FAILURE Program is unreliable!!!, 7K500 Test.UT FAILURE, 7K500 Test.".PHP_EOL."UT FAILURE, 7K500 Test.UT FAILURE, 7K500 Test.".PHP_EOL);
}



class drive
{
	public $drivePath;
	public $driveName;
	public $HWPath;
	public $serial;
	public $size;
	public $model;
	public $family;
	public $SureAnswer;
	public $pid;
	public $mode;
	public $startTime;
	public $erased;
	public $smartError;
	public $smart_reallocSectCount;
	public $smart_uncorrectCount;
	public $smart_reallocEventCount;
	public $smart_CurrentPendingCount;
	public $smart_offlineUncorrectCount;
	public $finalState;
	public $finalMsg;
	public $speed;
	public $networkRetryCount;
	
	function isRunning()
	{
		if($this->pid == 0)return false;
		try{
			$result = shell_exec(sprintf("ps %d", $this->pid));
			if( count(preg_split("/\n/", $result)) > 2){
				return true;
			}
		}catch(Exception $e){}
	
		return false;
	}
	
	function __construct($drivePath,$driveName)
	{
		$this->networkRetryCount =0;
		$this->startTime;
		$this->pid = 0;
		$this->mode="fault";
		$this->SureAnswer = 'n';
		//echo "Drive at : ".$drivePath.PHP_EOL;
		$this->drivePath = $drivePath;
		$this->driveName = $driveName;
		$this->smartError == true;
		$this->erased == false;
		$this->speed == "";
		
		$this->HWPath = substr(trim(shell_exec('udevadm info -q all -n '.$this->drivePath.' | grep DEVPATH')),3);
		
		shell_exec("smartctl --smart=on --offlineauto=on --saveauto=on ".$this->drivePath);
		
		$smartinfo = shell_exec('smartctl -i '.$this->drivePath);
		$smartLines = preg_split("/\r\n|\n|\r/", $smartinfo);
		//var_dump($smartinfo);
		foreach($smartLines AS $thisLine)
		{
			$elements = explode(":", $thisLine);
			if(sizeof($elements) == 2)
			{
				$op = strtolower(trim($elements[0]));
				$val = trim($elements[1]);
				if($op === "model family")
				{
					$this->family = preg_replace ('/[^a-z0-9\.\ ]/i', '', $val);
				}
				if($op === "device model" || $op == "product")
				{
					$this->model = preg_replace ('/[^a-z0-9\.\ ]/i', '', $val);
				}
				if($op === "serial number")
				{
					$this->serial = preg_replace ('/[^a-z0-9\.\ ]/i', '', $val);
				}
				if($op === "user capacity")
				{
					
					$openstrpos  = strpos($val,"[" );
					$closestrpos = strpos($val,"]");
					$size = substr($val, $openstrpos+1, $closestrpos-$openstrpos-1);
							
					//preg_match('/[-(.*?)-]/',$val, $size);
					
					//preg_match('~[(.*?)]~', $val, $size);
					//var_dump($size);
					$this->size = preg_replace ('/[^a-z0-9\.\ ]/i', '', $size);
				}
			}
			
		}
		//$this->printDriveIdent();
		//$this->printPartitonInfo();
	}
	
	function printDriveIdent($state = "")
	{
		echo"Drive = ".$this->drivePath.' IS '.$this->family.';  '.$this->model.';  '.$this->serial.';  '.$this->size.';  pid='.$this->pid.PHP_EOL
		  .$state.'  '.$this->HWPath.PHP_EOL;
	}
	
	function printPartitonInfo()
	{
		$parts = shell_exec('fdisk -l '.$this->drivePath);
		$index = strpos($parts, "Device");
		$result = substr($parts, $index);
		echo $result;
	}
	
	function AnswerDisk()
	{
		$this->printDriveIdent();
		$this->printPartitonInfo();
		while(true)
		{
			$response = substr(readline("ERASE THIS DISK?  E or [N],  A for abort:"),0,1);
			if ($response === "a" || $response === "A")die("User Aborted!".PHP_EOL);
			if ($response === "E" || $response === "e")
			{
				$this->SureAnswer = "e";
				$this->mode = "erase";
				break;
			}
			elseif ($response === "n" || $response === "N")
			{
				break;
			}
			else continue;
		}
	}
	
	
	
	function processDisk()
	{
		if($this->SureAnswer === "E" || $this->SureAnswer === "e")
		{
			if($this->mode === "erase")
			{
				$cmd = 'gfgDiskWipe '.$this->drivePath;
				exec(sprintf("%s > %s 2>&1 & echo $!", $cmd, '/tmp/wipeout_'.$this->driveName),$pidArr);
				$this->pid = $pidArr[0];
				//exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, '/tmp/wipeout_'.$this->driveName, '/tmp/wipepid_'.$this->driveName));
				system('touch /tmp/diskStart'.$this->driveName);
				
				echo'Erase Start. ';
				sleep(1);
				$this->mode = "eraseing";
				//$this->mode = "test";
				return "erase";
			}
			elseif($this->mode === "eraseing")
			{
				//echo"Eopen ";
				//sleep(10);
				if($this->isRunning() == false)
				{
					//if(file_exists('/tmp/diskStart'.$this->driveName))
					//{
						//echo'e';
						//sleep(1);
					//}
					//else
					{
						echo'teststart';
						sleep(1);
						$this->mode = "test";
						return "eraseing";
					}
				}
				else
				{
					//echo"Erunning ";
					//sleep(10);
				}
				$this->printDriveIdent("ERASING... ");
				$handle = fopen("/tmp/diskOut".$this->driveName, "r");
				if($handle)
				{
					echo fgets($handle); //Display Drive erase status
					echo PHP_EOL;
				}
				return "eraseing";
				
				
			}
			elseif($this->mode === "test")
			{
				$cmd = 'smartctl '.$this->drivePath.'-C -t short';
				shell_exec($cmd);
				$this->pid = 0;
				$this->mode = "testing";
				$this->startTime = time();
				return "test";
			}
			elseif($this->mode === "testing")
			{
				$tr = $this->startTime + 300 - time();
				if($tr < 0)
				{
					/*
					 * Fatal or unknown error";        break;
					    case 0x4: msgstat = "Completed: unknown failure";    break;
					    case 0x5: msgstat = "Completed: electrical failure"; break;
					    case 0x6: msgstat = "Completed: servo/seek failure"; break;
					    case 0x7: msgstat = "Completed: read failure";       break;
					    case 0x8: msgstat = "Completed: handling damage??";  break;
					    case 0x3: msg = "could not complete due to a fatal or unknown error"; break;
					    case 0x4: msg = "completed with error (unknown test element)"; break;
					    case 0x5: msg = "completed with error (electrical test element)"; break;
					    case 0x6: msg = "completed with error (servo/seek test element)"; break;
					    case 0x7: msg = "completed with error (read test element)"; break;
					    case 0x8: msg = "completed with error (handling damage?)"; break;
					 */
					
					$smartData = strtolower(shell_exec('smartctl /dev/'.$this->driveName.' -H'));
					$smartLog = strtolower(shell_exec('smartctl /dev/'.$this->driveName.' -l selftest'));
					$smartAttr = strtolower(shell_exec('smartctl /dev/'.$this->driveName.' -A'));
					$this->smartError == true;
					
					if(strpos($smartData,'PASSED') !== false)$this->smartError = false;// Must be found to be passing, or Fail drive
					
					echo "smartError1=".$this->smartError.PHP_EOL;
					//all the rest must not be found
					if(strpos($smartLog,'unknown failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'electrical failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'servo/seek failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'read failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'handling damage') !== false)$this->smartError = true;
					if(strpos($smartLog,'failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'unknown error') !== false)$this->smartError = true;
					if(strpos($smartLog,'completed with error') !== false)$this->smartError = true;
					echo "smartError2=".$this->smartError.PHP_EOL;
					
					/*
					 * seagate
					 	    5 Reallocated_Sector_Ct   0x0033   100   100   036    Pre-fail  Always       -       0
					 	  187 Reported_Uncorrect      0x0032   100   100   000    Old_age   Always       -       0
						  197 Current_Pending_Sector  0x0012   100   100   000    Old_age   Always       -       0
						  198 Offline_Uncorrectable   0x0010   100   100   000    Old_age   Offline      -       0
						samsung
						    5 Reallocated_Sector_Ct   0x0033   253   253   010    Pre-fail  Always       -       0
						  196 Reallocated_Event_Count 0x0032   253   253   000    Old_age   Always       -       0
						  197 Current_Pending_Sector  0x0012   253   253   000    Old_age   Always       -       0
						  198 Offline_Uncorrectable   0x0030   253   253   000    Old_age   Offline      -       0
						WD
						    5 Reallocated_Sector_Ct   0x0033   200   200   140    Pre-fail  Always       -       0
						  196 Reallocated_Event_Count 0x0032   253   253   000    Old_age   Always       -       0
						  197 Current_Pending_Sector  0x0012   200   200   000    Old_age   Always       -       0
						  198 Offline_Uncorrectable   0x0010   200   200   000    Old_age   Offline      -       0				
						Maxtor
						    5 Reallocated_Sector_Ct   0x0033   253   253   063    Pre-fail  Always       -       0
						  196 Reallocated_Event_Count 0x0008   253   253   000    Old_age   Offline      -       0
						  197 Current_Pending_Sector  0x0008   253   253   000    Old_age   Offline      -       0
						  198 Offline_Uncorrectable   0x0008   253   253   000    Old_age   Offline      -       0
						Hitachi  FAILING   UNERASEABLE SECTIONS
						    5 Reallocated_Sector_Ct   0x0033   100   100   005    Pre-fail  Always       -       12
						  196 Reallocated_Event_Count 0x0032   100   100   000    Old_age   Always       -       12
						  197 Current_Pending_Sector  0x0022   100   100   000    Old_age   Always       -       2
						  198 Offline_Uncorrectable   0x0008   100   100   000    Old_age   Offline      -       1
						   0           1                2       3     4     5        6         7         8       9
						   ID# ATTRIBUTE_NAME         FLAG    VALUE WORST THRESH    TYPE    UPDATED  WHEN_FAILED RAW_VALUE

					 */
					
					$attrLines = preg_split("/\r\n|\n|\r/",$smartAttr);
					$verifyedAtribs = 0;
					$verifyedRealloc = 0;
					foreach($attrLines AS $thisLine)
					{
						echo $thisLine.PHP_EOL;
						$el['id'] = 0;
						$el['name'] = 1;
						$el['flag'] = 2;
						$el['value'] = 3;
						$el['worst'] = 4;
						$el['threshold'] = 5;
						$el['type'] = 6;
						$el['updated'] = 7;
						$el['failedAt'] = 8;
						$el['raw'] = 9;
						//sleep(5);
						$elements = preg_split('/\s+/', trim($thisLine));
						//var_dump($elements);
						//$elements = preg_split('/[\s]+/', $thisLine);
						//var_dump($elements);
						if(strpos($thisLine,'reallocated_sector_ct') !== false)
						{
							echo "FOUND reallocSectCount".PHP_EOL;
							$verifyedAtribs++;
							$verifyedRealloc++;
							$this->smart_reallocSectCount = 'V='.trim($elements[$el['value']]).'W='.trim($elements[$el['worst']]).'R='.trim($elements[$el['raw']]);
							if( trim($elements[$el['value']]) === '100' && trim($elements[$el['worst']]) === '100' && ( trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'  )) continue;
							if( trim($elements[$el['value']]) === '253' && trim($elements[$el['worst']]) === '253' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '200' && trim($elements[$el['worst']]) === '200' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '252' && trim($elements[$el['worst']]) === '252' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue; //Samsung
							//if( trim($elements[$el['value']]) === '100' && trim($elements[$el['worst']]) === '100' && trim($elements[$el['raw']]) === '0' ) continue;
							
							echo "reallocSectCount = error = ".$this->smart_reallocSectCount.PHP_EOL;
							$this->smartError = true;
						}
						if(strpos($thisLine,'reported_uncorrect') !== false)
						{
						echo "FOUND uncorrectCount".PHP_EOL;
							$verifyedAtribs++;
							$this->smart_uncorrectCount = 'V='.trim($elements[$el['value']]).'W='.trim($elements[$el['worst']]).'R='.trim($elements[$el['raw']]);
							if( trim($elements[$el['value']]) === '100' && trim($elements[$el['worst']]) === '100' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '253' && trim($elements[$el['worst']]) === '253' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '100' && stringIsInString($this->family, "7K500"))continue; //Skip uncorrectable count on this model of hitachi drives,  as its a down counter.
							echo "uncorrectCount = error".$this->smart_uncorrectCount.PHP_EOL;
							$this->smartError = true;
						}
						if(strpos($thisLine,'reallocated_event_count') !== false)
						{
							echo "FOUND Reallocated_Event_Count".PHP_EOL;
							$verifyedAtribs++;
							$this->smart_reallocEventCount = 'V='.trim($elements[$el['value']]).'W='.trim($elements[$el['worst']]).'R='.trim($elements[$el['raw']]);
							if( trim($elements[$el['value']]) === '100' && trim($elements[$el['worst']]) === '100' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '253' && trim($elements[$el['worst']]) === '253' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '200' && trim($elements[$el['worst']]) === '200' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '252' && trim($elements[$el['worst']]) === '252' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;//Samsung
							echo "Reallocated_Event_Count = error".$this->smart_reallocEventCount.PHP_EOL;
							$this->smartError = true;
						}
						if(strpos($thisLine,'current_pending_sector') !== false)
						{
							echo "FOUND Current_Pending_Sector".PHP_EOL;
							$verifyedAtribs++;
							$this->smart_CurrentPendingCount = 'V='.trim($elements[$el['value']]).'W='.trim($elements[$el['worst']]).'R='.trim($elements[$el['raw']]);
							if( trim($elements[$el['value']]) === '100' && trim($elements[$el['worst']]) === '100' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '253' && trim($elements[$el['worst']]) === '253' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '200' && trim($elements[$el['worst']]) === '200' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '252' && trim($elements[$el['worst']]) === '252' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;//Samsung
							echo "Current_Pending_Sector = error".$this->smart_CurrentPendingCount.PHP_EOL;
							$this->smartError = true;
						}
						if(strpos($thisLine,'offline_uncorrectable') !== false)
						{
							echo "FOUND Offline_Uncorrectable".PHP_EOL;
							$verifyedAtribs++;
							$this->smart_offlineUncorrectCount = 'V='.trim($elements[$el['value']]).'W='.trim($elements[$el['worst']]).'R='.trim($elements[$el['raw']]);
							if( trim($elements[$el['value']]) === '100' && trim($elements[$el['worst']]) === '100' && (trim($elements[$el['raw']]) === '0'  || trim($elements[$el['raw']]) === '000'  )) continue;
							if( trim($elements[$el['value']]) === '253' && trim($elements[$el['worst']]) === '253' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;
							if( trim($elements[$el['value']]) === '100' && trim($elements[$el['worst']]) === '253' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;//2.5" wd blue
							if( trim($elements[$el['value']]) === '200' && trim($elements[$el['worst']]) === '200' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;//fujitsu
							if( trim($elements[$el['value']]) === '252' && trim($elements[$el['worst']]) === '252' && (trim($elements[$el['raw']]) === '0' || trim($elements[$el['raw']]) === '000'   )) continue;//Samsung
							echo "Offline_Uncorrectable = error".$this->smart_offlineUncorrectCount.PHP_EOL;
							$this->smartError = true;
						}
					}
					// Reallocated Sectors is mandatory,  must have at least 2 other values good and 0 bad values
					if($verifyedAtribs < 3 && $verifyedRealloc !== 1)$this->smartError = true;
					echo "smartError3=".$this->smartError.PHP_EOL;
					
					sleep(10);
					$this->mode = "send";
					return "send";
				}//if($this->startTime + 300 < time())
				$this->printDriveIdent("Testing Disk... $tr");
				echo PHP_EOL;
				return "testing";
			}
			elseif($this->mode === "send")
			{
				
				$passMessage = '===== PASSED,  Drive Erased';
				
				$diskDone = file_get_contents('/tmp/diskDone'.$this->driveName);
				
				$this->speed = str_getcsv($diskDone,"*");
				
				if(strpos($diskDone,$passMessage) !== false)
				{
					$state="p"; //p = pass,  everything erased that we can tell. Not valid for SSD's !!!
					echo"PASSED WIPE".PHP_EOL;
				}
				//$state="p";
				
				if($this->smartError === true)
				{
					$state .= "e";//e = error in smart data, or cant fully erase
					echo"FAILED SMART".PHP_EOL;
				}
				else
				{
					$state .= "s";
				}
				echo"CRCCALC=".strtolower($state.$this->family.$this->model.$this->serial.$this->size).PHP_EOL;
				$crc = crc32(strtolower($state.trim($this->family).trim($this->model).trim($this->serial).trim($this->size)));
				$l_family = urlencode($this->family);
				$l_model = urlencode($this->model);
				$l_serial = urlencode($this->serial);
				$l_size= urlencode($this->size);
				
				//$crc = crc32($state.$this->family.$this->model.$this->serial.$this->size);
				//prefix each option with a single pass fail Letter for security
				$cmd = 'curl "http://gfgdfserver/gfgdf/dataSubmit.php?family='.$state.$l_family.
				'&model='.$state.$l_model.
				'&serial='.$state.$l_serial.
				'&size='.$state.$l_size.
				'&reallocSectCount='.$state.urlencode($this->smart_reallocSectCount).
				'&uncorrectCount='.$state.urlencode($this->smart_uncorrectCount).
				'&reallocEventCount='.$state.urlencode($this->smart_reallocEventCount).
				'&CurrentPendingCount='.$state.urlencode($this->smart_CurrentPendingCount).
				'&offlineUncorrectCount='.$state.urlencode($this->smart_offlineUncorrectCount).
				'&crc='.$crc.
				'&speed='.$this->speed.'"';
				system($cmd);
				echo $cmd.PHP_EOL;
				sleep(10);
				$this->finalState = $state;
				$this->mode = 'read';
				return "send";
				
			}
			elseif($this->mode === "read")
			{
				$l_model = urlencode($this->model);
				$l_serial = urlencode($this->serial);
				
				$contents = trim(file_get_contents('http://gfgdfserver/gfgdf/getRes.php?'.
				'model='.$l_model.
				'&serial='.$l_serial));
				if($this->finalState == $contents)
				{
					$eraseState = substr($contents, 0,1);
					$smartState = substr($contents, 1,2);
					if($eraseState === "p" || $smartState === "s") $this->finalMsg = "+++ PASSED +++ ERASED +++";
					else if($eraseState === "p" || $smartState !== "s") $this->finalMsg = "+++ ERASED ++! SMART FAILURE !!! DISK FAILURE !!!";
					else if($eraseState !== "p" || $smartState === "s") $this->finalMsg = "!!! WIPE FAILURE !!! CONTAINS DATA !++ SMART OK +++";
					else $this->finalMsg = "!!! WIPE FAILURE !!! SMART FAILURE !!! DISK FAILURE !!!";
				}
				elseif($this->networkRetryCount < 5)
				{
					$this->finalMsg = "!!! SERVER COM FAILURE !!!";
					sleep(5);
					$this->mode = "send";
					return "send";
				}
				else
				{
					$this->finalMsg = "!!! SERVER COM FAILURE !!! 5 TRYS NO SERVER !!!";
				}
				$this->mode = 'done';
				return "read";
			}
			elseif($this->mode === "done")
			{
				$this->printDriveIdent($this->finalMsg);
				echo PHP_EOL;
				return "done";
			}
			echo'fFalut';
			return "fault";
			
		}
		return "fault";
	}
	function killProcessByDiskName($name)
	{
		if($this->driveName === $name)
		{
			$pid = $this->pid;
			if($pid !== 0)
			{
				$this->mode = 'done';
				system('kill '.$pid);
				$this->finalMsg = "!!!!!!!!ABORTED MID ERASE!!!!!!!!";
				echo PHP_EOL;
				$this->printDriveIdent($this->finalMsg);
				sleep(5);
				echo PHP_EOL;
			}
			else echo "Nothing to Abort, Disk is probably erased and in testing or finished!";
			sleep(5);
			return true;
		}
		
		return false;
	}
	
	//sudo udevadm info -q all -n /dev/sda | grep DEVPATH
}





system("clear");
$header = "=== Geeks 4 God - United Methodist Church of the Resurrection ===".PHP_EOL.
"=== DISK KILL AND TEST.  SECURE DRIVE ERASE. 11-04-2017 ===".PHP_EOL;
echo $header;
echo "".PHP_EOL;
echo "No warrenty given,  This may not work. And its not our fault!".PHP_EOL;
echo "".PHP_EOL;
echo "NETWORK STATUS".PHP_EOL;
$ipInfo = preg_split("/\r\n|\n|\r/",shell_exec("ifconfig"));
echo $ipInfo[0].PHP_EOL;
echo $ipInfo[1].PHP_EOL;
echo $ipInfo[2].PHP_EOL;
echo "".PHP_EOL;
echo "WARNING WARNING WARNING".PHP_EOL;
echo "This program will erase all detected hard drives. Permanently!".PHP_EOL;
$response = substr(readline("Press Y to continue. [No] :"),0,1);
echo "";
if ($response !== 'Y' && $response !== 'y')
{
	echo "Disks not wiped. User canciled or didnt use an uppercase Y.".PHP_EOL;
	echo "".PHP_EOL;
	echo "type  gdelete.bash to rerun.".PHP_EOL;
	die("end ");
}
$devices;
chdir('/dev');
$fileDevice_h = new FilesystemIterator("/dev");
foreach($fileDevice_h AS $thisDevice)
{
	if($thisDevice->getType() !== "block")continue;
	//echo "e".$thisDevice->getPathname()." type=".$thisDevice->getType().PHP_EOL;
	
	//if($thisDevice->isLink())
	{
		//echo "f";
		if(substr($thisDevice->getFilename(),0,2) === "sd" && strlen($thisDevice->getFilename()) === 3 )
		{
			$devices[$thisDevice->getFilename()] = new drive($thisDevice->getPathname(),$thisDevice->getFilename());
		}
	}
	
}

if(empty($devices)) die( "No hard drives found!".PHP_EOL);
//var_dump($devices);

sort($devices);

//Get Per disk Confermation
foreach($devices AS $thisDevice)
{
	system("clear");
	echo $header.PHP_EOL;
	$thisDevice->AnswerDisk();
}

function nonBlockingReadLineFromStdIn()
{
	$read = array(STDIN);
	$write = array();
	$except = array();

	//var_dump('Before stream select.');
	$result = stream_select($read, $write, $except, 5);
	//var_dump('After stream select.', $result);

	if ($result === false) {
		throw new RunTimeException("Can not select stream STDIN");
	}

	if ($result === 0) {
		return false;
	}

	//var_dump('Before get line.');
	$getLine = stream_get_line(STDIN, 1);
	//var_dump('After get line.', $getLine);

	return $getLine;
}

//$fp=fopen('php://stdin','r');
//stream_set_timeout($fp,5);
//stream_set_blocking($fp,false);

//Erase Disk
$finished = false;
while($finished == false)
{
	//sleep(5);
	//$charIn = fgetc($fp);
	$charIn = nonBlockingReadLineFromStdIn();
	system("clear");
	echo $header.PHP_EOL;
	$finished = true;
	foreach($devices AS $thisDevice)
	{
		$ret = $thisDevice->processDisk();
		if($ret !== "done" && $ret !== "fault")
		{
			$finished = false;
		}
		else
		{
			echo'finshed='.$ret.PHP_EOL;
		}
	}
	//stream_select (array(STDIN),array(),array(),5);
	echo "==  TYPE K to end a process that has failed. ==".PHP_EOL;
	if($charIn === 'k')
	{
		$in = trim(readline('Enter the disk name to abort, ie sde, All others resume.: '));
		if(strlen($in) == 3 )
		{
			$prefix = substr($in, 0,2);
			if($prefix == 'sd')
			{
				echo 'TERM '.$in;
				sleep(1);
				foreach($devices AS $thisDevice)
				{
					if ( $thisDevice->killProcessByDiskName($in) == true ) break;
				}
			}
		}
	}
	else
	{
		//echo "chars = ".$charIn;
	}
	
}
sleep(1);
system("clear");
echo $header;
foreach($devices AS $thisDevice)
{
	echo "".PHP_EOL;
	$ret = $thisDevice->processDisk();
	
}














?>
