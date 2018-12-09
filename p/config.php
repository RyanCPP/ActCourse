<?php
 
$config = parse_ini_file('config.ini');

$link = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
