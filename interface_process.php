<?php

$isSwipe   = strpos($_GET["robot"], 'Swipe');
$isInsert  = strpos($_GET["robot"], 'Insert');
$isTapster = strpos($_GET["robot"], 'Tapster');
$isDisplay = strpos($_GET["robot"], 'Display');
if($isTapster !== false)
{
	$isTap = false;
	}
	else
	{
		$isTap     = strpos($_GET["robot"], 'Tap');
		}
$isCombo   = strpos($_GET["robot"], 'Combo');

if($isSwipe !== false) 
{
  exec ("python robot_interface.py Swipe " . $_GET["command"] . " 2>&1", $status);
}
if($isInsert !== false) 
{
  exec ("python robot_interface.py Insert " . $_GET["command"] . " 2>&1", $status);
}
if($isTapster !== false) 
{
  exec ("python robot_interface.py Tapster " . $_GET["command"] . " 2>&1", $status);
}
if($isTap !== false) 
{
  exec ("python robot_interface.py Tap " . $_GET["command"] . " 2>&1", $status);
}
if($isDisplay !== false) 
{
    if($_GET["additional"] === "QR")
    {
		$show_command = "show_qr.sh";
		$kill_command = "kill_qr.sh";
    }

    if($_GET["additional"] === "BAR")
    {
		$show_command = "show_bar.sh";
		$kill_command = "kill_qr.sh";
    }

    if($_GET["additional"] === "BENDER")
    {
		$show_command = "show_bender.sh";
		$kill_command = "kill_qr.sh";
    }

    if($_GET["command"] !== "kill_code")
	{ 
	    exec ("/var/www/html/" . $show_command . " "  . $_GET["command"] . " 2>&1", $status);
	}else
	{
	    exec ("/var/www/html/" . $kill_command . " 2>&1", $status);
	}
}


if($isCombo !== false) 
{
	if(strpos($_GET["command"], 'handshake') !== false)
	{
		exec ("python handshake.py 2>&1", $status);
	}
}


foreach ($status as $value)
{
    if(strpos($value,"scanned") !== false)
		{continue;}
    echo ($value."<br>");
	
    
}

?>
