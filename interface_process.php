<?php

$isSwipe   = strpos($_GET["robot"], 'Swipe');
$isInsert  = strpos($_GET["robot"], 'Insert');
$isTapster = strpos($_GET["robot"], 'Tapster');
$isScan    = strpos($_GET["robot"], 'Scan');
$isVoice   = strpos($_GET["robot"], 'Voice');

if($_GET["command"]==="")
{
  exit("Command is empty. Please specify the command.");
}

if($isTapster !== false)
{
	$isTap = false;
	}
	else
	{
		$isTap     = strpos($_GET["robot"], 'Tap');
		}
$isCombo   = strpos($_GET["robot"], 'Combo');


if($isVoice !== false)
{
  $phrase = '"' . $_GET["command"] . '"';
  exec ("/var/www/html/voice.sh "  . $phrase . "> /dev/null 2>&1", $status);
  exit(file_get_contents("/home/pi/uploads//transcribe.out"));
  
}
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

if($isScan !== false) 
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

    $cmd = '"' . $_GET["command"] . '"';
    exec ("/var/www/html/" . $show_command . " "  . $cmd . "> /dev/null 2>&1", $status);
    exec ("python robot_interface.py Swipe 9 > /dev/null 2>&1", $status);
    sleep(2);
    exec ("/var/www/html/" . $kill_command . "> /dev/null 2>&1", $status);

    $status = array("{\"response\" : \"DONE (Scanner robot)\"}");
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
