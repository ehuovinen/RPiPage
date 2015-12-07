<?php
error_reporting(E_ALL);
session_start();
/*
if(!array_key_exists('smHandle',$_SESSION)){
	$_SESSION['smHandle']=shmop_open(0x3000,'a',0,0);
	if ($_SESSION['smHandle']==False){
		session_destroy();
		die("control program is not running");
	}
}
*/

echo
"
<!DOCTYPE HTML>
<html manifest='cache.manifest'>
<head>
<meta http-equiv='refresh' content='1'>
</head>
<style>
#main{
	width : 40%;
	margin-left : auto;
	margin-right : auto;
}
#title{
	width : 100%;
	float : left;
	font-size : 60px;
	font-weight : bold;
	text-align : center;
	margin-bottom : 5px;
}

#tLightBox{
	width : 50%;
	float : left;
	background-color : gray;
}
#ctrls{
	width : 50%;
	float : left;
	background-color : lightyellow;
}
#ctrls button{
	width : 100%;
	height : 3em;
	font-size : 40px;
	
}
</style>
<body>
<div id='main'>
";
if(array_key_exists('c',$_GET)){
	$command="";
	switch ($_GET["c"]){
		case "sr":
			$command="setRed\n";
			break;
		case "rr":
			$command="resetRed\n";
			break;
		case "sy":
			$command="setYellow\n";
			break;
		case "ry":
			$command="resetYellow\n";
			break;
		case "sg":
			$command="setGreen\n";
			break;
		case "rg":
			$command="resetGreen\n";
			break;
		case "as":
			$command="activateSequence\n";
			break;
		case "ds":
			$command="deactivateSequence\n";
			break;
		default:
			$command="unrecognizedGet\n";
			break;
	}
	unset($_GET);
	$out = fopen("/tmp/commandPipe","w");
	fwrite($out,$command);
	fclose($out);
	header("Location: index.php");
	exit();
}
if(array_key_exists('btn',$_GET)){
	$command="";
	switch ($_GET["btn"]){
		case "as":
			$command="activateSequence\n";
			break;
		case "ds":
			$command="deactivateSequence\n";
			break;
		case "a1":
			$command="turnOn\n";
			break;
		case "a0":
			$command="turnOff\n";
			break;
		default:
			$command="unrecognizedGet\n";
			break;
	}
	unset($_GET);
	$out = fopen("/tmp/commandPipe","w");
	fwrite($out,$command);
	fclose($out);
	header("Location: index.php");
	exit();
}

$handle=shmop_open(0x3000,'a',0,0);
$rv=shmop_read($handle,0,10);
echo '	
	<div id="title">group 12</br> Trafic Light</div>
	<div id="tLightBox">
	<svg width="100%" height="100%" viewbox="0 0 70 175">
';

if ($rv[0]=="T"){
	echo '
		<a xlink:href="?c=rr">
		<circle cx="35" cy="30" r="25" stroke="black" stroke-width="1" fill="red">
		</a>
	';
}else{
	echo '
		<a xlink:href="?c=sr">
		<circle cx="35" cy="30" r="25" stroke="black" stroke-width="1" fill="lightgray">
		</a>
	';
}

if ($rv[1]=="T"){
	echo '
		<a xlink:href="?c=ry">
		<circle cx="35" cy="85" r="25" stroke="black" stroke-width="1" fill="yellow">
		</a>
	';
}else{
	echo '
		<a xlink:href="?c=sy">
		<circle cx="35" cy="85" r="25" stroke="black" stroke-width="1" fill="lightgray">
		</a>
	';
}

if ($rv[2]=="T"){
	echo '
		<a xlink:href="?c=rg">
		<circle cx="35" cy="140" r="25" stroke="black" stroke-width="1" fill="lime">
		</a>
	';
}else{
	echo '
		<a xlink:href="?c=sg">
		<circle cx="35" cy="140" r="25" stroke="black" stroke-width="1" fill="lightgray">
		</a>
	';
}

echo "
</svg>
</div>
<div id='ctrls'>
	<form action='index.php' method='get'>
";

if ($rv[3]=="T"){
	echo "
		<button type='submit' name='btn' value='ds'>Deactivate Sequence</button>
	";
}else{
	echo "
		<button type='submit' name='btn' value='as'>Activate Sequence</button>
	";
}

echo"
	<button type='submit' name='btn' value='a1'>All ON</button>
	<button type='submit' name='btn' value='a0'>All OFF</button>
	</form>
</div>
<p><a href='diagram.html'>Diagram</a>
";//id="frm1_submit" 
?>
