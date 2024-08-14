<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ev_db";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)){
    die("Failed Connection");
}