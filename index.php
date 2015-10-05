<?php
error_reporting(E_ALL);
session_start();
if(!array_key_exists('smHandle',$_SESSION)){
	$_SESSION['smHandle']=shmop_open(0x3000,'a',0,0);
	if ($_SESSION['smHandle']==False){
		session_destroy();
		die("control program is not running");
	}
}

echo
"
<!DOCTYPE HTML>
<html manifest='cache.manifest'>
<head>
</head>
<style>
</style>
<body>
";
$handle=shmop_open(0x3000,'a',0,0);
$rv=shmop_read($handle,0,10);
if ($rv[0]=="T"){
	echo '<p>RED
<svg width="100" height="100">
<a xlink:href="http://www.google.com">
	<circle cx="50" cy="50" r="30" stroke="black" stroke-width="1" fill="red">
<a>
</svg>
';
}else{echo '<p>not red
<svg width="100" height="100">
<a xlink:href="http://www.google.com">
	<circle cx="50" cy="50" r="30" stroke="black" stroke-width="1" fill="gray">
<a>
</svg>
';}

if ($rv[1]=="T"){
	echo '<p>YELLOW';
}else{echo '<p>not yellow';}

if ($rv[2]=="T"){
	echo '<p>GREEN';
}else{echo '<p>not green';}

echo"<p><a href='logout.php'>Logout</a>";
?>
