#!/usr/bin/php
<?php
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
	public $smartError;
	public $smart_reallocSectCount;
	public $smart_uncorrectCount;
	public $smart_reallocEventCount;
	public $smart_CurrentPendingCount;
	public $smart_offlineUncorrectCount;
	
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
		$this->startTime;
		$this->pid = 0;
		$this->mode="fault";
		$this->SureAnswer = n;
		//echo "Drive at : ".$drivePath.PHP_EOL;
		$this->drivePath = $drivePath;
		$this->driveName = $driveName;
		$this->smartError == true;
		
		$this->HWPath = trim(shell_exec('udevadm info -q all -n '.$this->drivePath.' | grep DEVPATH'));
		
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
		echo"Drive = ".$this->drivePath.' IS '.$this->family.';  '.$this->model.';  '.$this->serial.';  '.$this->size.PHP_EOL.
		'pid='.$this->pid.'  '.$state.'    '.$this->HWPath.PHP_EOL;
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
			$response = readline("ERASE THIS DISK?  E or [N],  A for abort:");
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
				
				$this->mode = "eraseing";
				return "erase";
			}
			elseif($this->mode === "eraseing")
			{
				if($this->isRunning() == false)
				{
					if(file_exists('/tmp/diskStart'.$this->driveName))
					{
						
					}
					else
					{
						$this->mode = "test";
						return "eraseing";
					}
				}
				else
				{
					
					
				}
				$this->printDriveIdent("ERASING... ");
				$handle = fopen("/tmp/diskOut".$this->driveName, "r");
				if($handle)
				{
					echo fgets($handle); //Display Drive erase status
					echo PHP_EOL;
				}
				
				
			}
			elseif($this->mode === "test")
			{
				$cmd = 'smartctl '.$this->drivePath.'-C -t short';
				exec(sprintf("$s > $s 2>&1 & echo $1", $cmd, '/tmp/wipeout_'.$this->driveName),$pidArr);
				$this->pid = $pidArr[0];
				$this->mode = "testing";
				$this->startTime = time();
				return "test";
			}
			elseif($this->mode === "testing")
			{
				if($this->startTime + 300 < time())
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
					
					//all the rest must not be found
					if(strpos($smartLog,'unknown failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'electrical failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'servo/seek failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'read failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'handling damage') !== false)$this->smartError = true;
					if(strpos($smartLog,'failure') !== false)$this->smartError = true;
					if(strpos($smartLog,'unknown error') !== false)$this->smartError = true;
					if(strpos($smartLog,'completed with error') !== false)$this->smartError = true;
					
					
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
						
						$elements = preg_split('/\s+/', $thisLine);
						if(strpos($smartLog,'Reallocated_Sector_Ct') !== false)
						{
							$verifyedAtribs++;
							$verifyedRealloc++;
							if( $elements[$el['value']] === '100' && $elements[$el['worst']] === '100' && $elements[$el['raw']] === '0' ) continue;
							if( $elements[$el['value']] === '253' && $elements[$el['worst']] === '253' && $elements[$el['raw']] === '0' ) continue;
							if( $elements[$el['value']] === '200' && $elements[$el['worst']] === '200' && $elements[$el['raw']] === '0' ) continue;
							//if( $elements[$el['value']] === '100' && $elements[$el['worst']] === '100' && $elements[$el['raw']] === '0' ) continue;
							$this->smart_reallocSectCount = 'V='.$elements[$el['value']].'W='.$elements[$el['worst']].'R='.$elements[$el['raw']];
							$this->smartError = true;
						}
						if(strpos($smartLog,'Reported_Uncorrect') !== false)
						{
							$verifyedAtribs++;
							if( $elements[$el['value']] === '100' && $elements[$el['worst']] === '100' && $elements[$el['raw']] === '0' ) continue;
							if( $elements[$el['value']] === '253' && $elements[$el['worst']] === '253' && $elements[$el['raw']] === '0' ) continue;
							$this->smart_uncorrectCount = 'V='.$elements[$el['value']].'W='.$elements[$el['worst']].'R='.$elements[$el['raw']];
							$this->smartError = true;
						}
						if(strpos($smartLog,'Reallocated_Event_Count') !== false)
						{
							$verifyedAtribs++;
							if( $elements[$el['value']] === '100' && $elements[$el['worst']] === '100' && $elements[$el['raw']] === '0' ) continue;
							if( $elements[$el['value']] === '253' && $elements[$el['worst']] === '253' && $elements[$el['raw']] === '0' ) continue;
							$this->smart_reallocEventCount = 'V='.$elements[$el['value']].'W='.$elements[$el['worst']].'R='.$elements[$el['raw']];
							$this->smartError = true;
						}
						if(strpos($smartLog,'Current_Pending_Sector') !== false)
						{
							$verifyedAtribs++;
							if( $elements[$el['value']] === '100' && $elements[$el['worst']] === '100' && $elements[$el['raw']] === '0' ) continue;
							if( $elements[$el['value']] === '253' && $elements[$el['worst']] === '253' && $elements[$el['raw']] === '0' ) continue;
							if( $elements[$el['value']] === '200' && $elements[$el['worst']] === '200' && $elements[$el['raw']] === '0' ) continue;
							$this->smart_CurrentPendingCount = 'V='.$elements[$el['value']].'W='.$elements[$el['worst']].'R='.$elements[$el['raw']];
							$this->smartError = true;
						}
						if(strpos($smartLog,'Offline_Uncorrectable') !== false)
						{
							$verifyedAtribs++;
							if( $elements[$el['value']] === '100' && $elements[$el['worst']] === '100' && $elements[$el['raw']] === '0' ) continue;
							if( $elements[$el['value']] === '253' && $elements[$el['worst']] === '253' && $elements[$el['raw']] === '0' ) continue;
							if( $elements[$el['value']] === '200' && $elements[$el['worst']] === '200' && $elements[$el['raw']] === '0' ) continue;
							$this->smart_offlineUncorrectCount = 'V='.$elements[$el['value']].'W='.$elements[$el['worst']].'R='.$elements[$el['raw']];
							$this->smartError = true;
						}
					}
					// Reallocated Sectors is mandatory,  must have at least 2 other values good and 0 bad values
					if($verifyedAtribs < 3 && $verifyedRealloc !== 1)$this->smartError = true;
					
					
					
					$this->mode = "send";
					return "send";
				}//if($this->startTime + 300 < time())
				$this->printDriveIdent("Testing Disk...");
			}
			elseif($this->mode === "send")
			{
				$state="f"; //fail
				$passMessage = '===== PASSED,  Drive Erased';
				
				$diskDone = file_get_contents('/tmp/diskDone'.$this->driveName);
				
				if(strpos($diskDone,$passMessage) !== false)$state="p"; //p = pass,  everything erased that we can tell. Not valid for SSD's !!!
				
				if($this->smartError === true)$state="e";//e = error in smart data, or cant fully erase
				
				$crc = crc32($state.$this->family.$this->model.$this->serial.$this->size);
				//prefix each option with a single pass fail Letter for security
				system('curl "http://gfgdfserver/gfgdf/dataSubmit.php?family='.$state.$this->family.
				'&model='.$state.$this->model.
				'&serial='.$state.$this->serial.
				'&reallocSectCount='.$state.$this->smart_reallocSectCount.
				'&uncorrectCount='.$state.$this->smart_uncorrectCount.
				'&reallocEventCount='.$state.$this->smart_reallocEventCount.
				'&CurrentPendingCount='.$state.$this->smart_CurrentPendingCount.
				'&offlineUncorrectCount='.$state.$this->smart_offlineUncorrectCount.
				'&crc='.$crc.'"');
				
				$this->mode = 'read';
				return "send";
				
			}
			elseif($this->mode === "read")
			{
				$this->mode = 'done';
				return "read";
			}
			elseif($this->mode === "done")
			{
				return "done";
			}
			return "fault";
			
		}
	}
	
	//sudo udevadm info -q all -n /dev/sda | grep DEVPATH
}





system("clear");
$header = "=== Geeks 4 God - United Methodist Church of the Resurrection ===".PHP_EOL.
"=== DISK KILL AND TEST.  SECURE DRIVE ERASE. 07-22-2017===".PHP_EOL;
echo $header;
echo "".PHP_EOL;
echo "No warrenty given,  This may not work. And its not our fault!".PHP_EOL;
echo "".PHP_EOL;
echo "Network Status".PHP_EOL;
//ifconfig
echo "";
echo "WARNING WARNING WARNING".PHP_EOL;
echo "This program will erase all detected hard drives. Permanently!".PHP_EOL;
$response = readline("Press Y to continue. [No] :");
echo "";
if ($response != "Y" || $response != "y")
{
	echo "Disks not wiped. User canciled or didnt use an uppercase Y.".PHP_EOL;
	echo "".PHP_EOL;
	echo "type  gdelete.bash to rerun.".PHP_EOL;
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



//Erase Disk
$finished = false;
while($finished == false)
{
	echo $header.PHP_EOL;
	sleep(1);
	system("clear");
	$finished = true;
	foreach($devices AS $thisDevice)
	{
		$ret = $thisDevice->processDisk();
		if($ret != "done" || $ret != "fault") $finished = false;
	}
	
}
















?>
