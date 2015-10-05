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
<meta http-equiv='refresh' content='10'>
</head>
<style>
#tLightBox{
	width : 100px;
	height : 300px;
}
</style>
<body>
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
if ($rv[0]=="T"){
	echo '
		<div id="tLightBox">
		<svg width="100" height="80">
		<a xlink:href="?c=rr">
		<circle cx="50" cy="40" r="30" stroke="black" stroke-width="1" fill="red">
		</a>
		</svg>
	';
}else{
	echo '
		<div id="tLightBox">
		<svg width="100" height="80">
		<a xlink:href="?c=sr">
		<circle cx="50" cy="40" r="30" stroke="black" stroke-width="1" fill="gray">
		</a>
		</svg>
	';
}

if ($rv[1]=="T"){
	echo '
		<svg width="100" height="80">
		<a xlink:href="?c=ry">
		<circle cx="50" cy="40" r="30" stroke="black" stroke-width="1" fill="yellow">
		</a>
		</svg>
	';
}else{
	echo '
		<svg width="100" height="80">
		<a xlink:href="?c=sy">
		<circle cx="50" cy="40" r="30" stroke="black" stroke-width="1" fill="gray">
		</a>
		</svg>
	';
}

if ($rv[2]=="T"){
	echo '
		<svg width="100" height="80">
		<a xlink:href="?c=rg">
		<circle cx="50" cy="40" r="30" stroke="black" stroke-width="1" fill="lime">
		</a>
		</svg>
	';
}else{
	echo '
		<svg width="100" height="80">
		<a xlink:href="?c=sg">
		<circle cx="50" cy="40" r="30" stroke="black" stroke-width="1" fill="gray">
		</a>
		</svg>
</div>
	';
}

echo"<p><a href='logout.php'>Logout</a>";
?>
