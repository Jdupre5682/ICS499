<!DOCTYPE html>
<html lang="en"  >

<head>
<link rel="icon" href="images/favicon.jpg" type="image/x-icon">
  <link href="./styles.css" rel="stylesheet" type="text/css" media="all" />
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>

  <title>EV Car Rentals</title>

</head>
<body>

<?php include "header.php"; 
require_once "connection.php";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// establist connection with database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//set charset to utf-8
$conn->set_charset("utf8");
//create sql
$sql = "SELECT * FROM cars ORDER BY RAND()";
$result = $conn->query($sql);

if(isset($_POST['filter_option'])){
if($_POST['filter_option'] == 'Tesla'){
  $sql = "SELECT * FROM cars WHERE type LIKE 'Tesla'";
  $result = $conn->query($sql);
}else if($_POST['filter_option'] == 'Nissan'){
  $sql = "SELECT * FROM cars WHERE type LIKE 'Nissan'";
  $result = $conn->query($sql);

}
}



?>

<h1 style="text-align:center">Welcome To EV Car Rentals</h1>

<form name="filter" method="POST" style="text-align: center;">
  <select name="filter_option" id="filter_option" onchange="this.form.submit()">
    <option value="all" selected="selected">Filter By Type</option>
    <option value="Tesla">Tesla</option>
    <option value="Rivian">Riviany</option>
    <option value="Ford">Ford</option>
    <option value="Kia">Kia</option>
    </select>

<main> 

<?php

while ($row = mysqli_fetch_assoc($result)) {
  
 ?>
 <a style="text-decoration: none" href=<?php echo'view-car.php?id='. $row["CarID"];?>>
        <div class="card">
          <div class="card-item">
          <p style="font-size: 14px;" class="type"><?php echo $row["RentalRatePerDay"] . " Per day"; ?></p>
          <p><b><?php echo '<img src="logos/' . $row["Image"] .'" style="max-width: 150px;">'; ?></b></p>
              <p style="font-size: 20px; padding:1em;" class="topic_name"><?php echo $row["Make"]; ?></p>
              <p style="font-size: 12px; padding:1em;" class="description">
  <?php echo substr($row["Year"], 0, 100); ?>
</p>
              </a>
              </div>
            </div></br>
            <?php
}
            ?>
          </main>
</html>
