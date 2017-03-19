<?php

$isSwipe   = strpos($_GET["file"], 'Swipe');
$isInsert  = strpos($_GET["file"], 'Insert');
$isTapster = strpos($_GET["file"], 'Tapster');

$knownRobot = 0;

if($isTapster !== false)
{
	$isTap = false;
	}
	else
	{
		$isTap     = strpos($_GET["file"], 'Tap');
		}

if($isSwipe !== false) 
{
  exec ("avrdude -patmega328p -carduino -P/dev/ttySwipe -b115200 -D -Uflash:w:/home/pi/uploads/".$_GET["file"].":i 2>&1", $status);
  $knownRobot = 1;
}
if($isInsert !== false) 
{
  exec ("avrdude -patmega644p -carduino -P/dev/ttyInsert -b38400 -D -Uflash:w:/home/pi/uploads/".$_GET["file"].":i 2>&1", $status);
  $knownRobot = 1;
}
if($isTapster !== false) 
{
  exec ("avrdude -patmega328p -carduino -P/dev/ttyTapster -b115200 -D -Uflash:w:/home/pi/uploads/".$_GET["file"].":i 2>&1", $status);
  $knownRobot = 1;
}
if($isTap !== false) 
{
  exec ("avrdude -patmega328p -carduino -P/dev/ttyTap -b115200 -D -Uflash:w:/home/pi/uploads/".$_GET["file"].":i 2>&1", $status);
  $knownRobot = 1;
}

if($knownRobot == 0)
{
    echo "Unknown robot type. Check name of your firmware file";
}else
{
    foreach ($status as $value)
	echo ($value."<br>");
}

?>
