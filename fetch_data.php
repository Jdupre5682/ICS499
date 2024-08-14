<?php
session_start();
require_once "connection.php";

$user_id = "";
$CarID = "";
$Make = "";
$Model = "";
$Year = "";
$LicensePlate = "";
$Color = "";
$BatteryCapacity = "";
$RangePerCharge = "";
$RentalRatePerDay = "";
$Image = "";
$Manager = "";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// establish connection with database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//set charset to utf-8
$conn->set_charset("utf8");

$sql = "SELECT * FROM cars";

$result = $conn->query($sql);
$array = array();

while ($row = $result->fetch_assoc()) {
    $array[] = $row;
}

$dataset = array(
    "echo" => 1,
    "totalrecords" => count($array),
    "totaldisplayrecords" => count($array),
    "data" => $array
);

echo json_encode($dataset);
