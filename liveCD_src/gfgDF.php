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
		$this->pid = 0;
		$this->mode="fault";
		$this->SureAnswer = n;
		//echo "Drive at : ".$drivePath.PHP_EOL;
		$this->drivePath = $drivePath;
		$this->driveName = $driveName;
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
					$this->family = $val;
				}
				if($op === "device model" || $op == "product")
				{
					$this->model = $val;
				}
				if($op === "serial number")
				{
					$this->serial = $val;
				}
				if($op === "user capacity")
				{
					
					$openstrpos  = strpos($val,"[" );
					$closestrpos = strpos($val,"]");
					$size = substr($val, $openstrpos+1, $closestrpos-$openstrpos-1);
							
					//preg_match('/[-(.*?)-]/',$val, $size);
					
					//preg_match('~[(.*?)]~', $val, $size);
					//var_dump($size);
					$this->size = $size;
				}
			}
			
		}
		//$this->printDriveIdent();
		//$this->printPartitonInfo();
	}
	
	function printDriveIdent($state = "")
	{
		echo"Drive = ".$this->drivePath.' IS '.$this->family.';  '.$this->model.';  '.$this->serial.';  '.$this->size.PHP_EOL.
		$state.'  '.$this->HWPath.PHP_EOL;
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
				//$cmd = 'gfgDiskWipe '.$this->drivePath;
				exec(sprintf("$s > $s 2>&1 & echo $1", $cmd, '/tmp/wipeout_'.$this->driveName),$pidArr);
				$this->pid = $pidArr[0];
				//exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, '/tmp/wipeout_'.$this->driveName, '/tmp/wipepid_'.$this->driveName));
				return "erase";
				$this->mode = "eraseing";
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
					echo fgets($handle);
					echo PHP_EOL;
				}
				
				
			}
			elseif($this->mode === "test")
			{
				$cmd = 'smartctl '.$this->drivePath.'-C -t short';
				exec(sprintf("$s > $s 2>&1 & echo $1", $cmd, '/tmp/wipeout_'.$this->driveName),$pidArr);
				$this->pid = $pidArr[0];
				return "test";
			}
			elseif($this->mode === "testing")
			{
				if($this->isRunning() == false)
				{
					$this->mode = "test";
					return "send";
				}
				$this->printDriveIdent("Testing Disk...");
			}
			elseif($this->mode === "send")
			{
				
			}
			elseif($this->mode === "read")
			{
				
			}
			elseif($this->mode === "done")
			{
				
			}
			return "falut";
			
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


foreach($devices AS $thisDevice)
{
	system("clear");
	echo $header.PHP_EOL;
	$thisDevice->AnswerDisk();
}


$finished = false;
while($finished == false)
{
	echo $header.PHP_EOL;
	system("clear");
	$finished = true;
	foreach($devices AS $thisDevice)
	{
		$ret = $thisDevice->processDisk();
		if($ret != "done" || $ret != "fault") $finished = false;
	}
}
















?>
