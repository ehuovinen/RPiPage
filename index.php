<?php
/*
function get_key($fsize, $file){
    if(!file_exists("TMPDIR"."TMPPRE".$file)){
        touch("TMPDIR"."TMPPRE".$file);
    }
    $shmkey = @shmop_open(ftok("TMPDIR"."TMPPRE".$file, 'R'), "c", 0644, $fsize);
    if(!$shmkey) {
            return false;
    }else{
        return $shmkey;
    }
}
 */

echo
"
<!DOCTYPE HTML>
<html>
<head>
</head>
<style>
</style>
<body>
";

$shm_key=242424;
$shm_id=shmop_open($shm_key,'a',0,0);
$rv=shmop_read($shm_id,0,4);
if (!$rv){
    echo "failed to read from shm_id".$shm_id;
}
else{
    echo "the shared memory contains ".$rv;
}
shmop_close($shm_id);
echo
"
<h1>here we go again</h>
<h2>The shm key is ".$shm_key."</h>
<h2>The shm id is ".$shm_id."</h>
<h2>The rv is ".$rv[0]."</h>
</body>
</html>
";
?>
