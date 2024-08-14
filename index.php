<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <link href="styles.css" rel="stylesheet" type="text/css" media="all" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>
    <title>EV Car Rentals</title>
    <style type="text/css">
/* General styles for the body */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #1c1c1c;
    color: #f5f5f5;
}

/* Heading styles */
h1 {
    text-align: center;
    margin: 20px 0;
    color: #00bcd4;
}

/* Styles for the form */
form {
    text-align: center;
    margin: 20px 0;
}

select {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #00bcd4;
    border-radius: 5px;
    background-color: #2c2c2c;
    color: #f5f5f5;
    cursor: pointer;
}

/* Styles for the main content */
main {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 20px;
}

/* Card Styles */
.card {
    background-color: #2c2c2c;
    border: 1px solid #00bcd4;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    margin: 10px;
    width: 250px;
    text-align: center;
    transition: transform 0.2s;
    overflow: hidden;
    position: relative;
}

.card:hover {
    transform: scale(1.05);
}

.card-item {
    padding: 20px;
}

.card-item img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    margin-bottom: 15px;
}

.card-item p {
    margin: 10px 0;
    color: #f5f5f5;
}

.card-item .type {
    font-size: 14px;
    color: #00bcd4;
}

.card-item .topic_name {
    font-size: 20px;
    font-weight: bold;
    color: #00bcd4;
}

.card-item .description {
    font-size: 12px;
    color: #b0b0b0;
}

/* Styles for the header and footer */
.header, .footer {
    padding: 20px;
    background-color: #00bcd4;
    text-align: center;
    color: white;
    border-radius: 10px;
    margin-bottom: 20px;
}

.header a, .footer a {
    color: white;
    text-decoration: none;
    font-size: 24px;
    font-weight: bold;
}

.header a:hover, .footer a:hover {
    text-decoration: underline;
}

    </style>


</head>
<body>

<?php
include "header.php";
require_once "connection.php";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// establish connection with database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// set charset to utf-8
$conn->set_charset("utf8");
// create sql
$sql = "SELECT DISTINCT Make FROM cars ORDER BY Make";
$make_result = $conn->query($sql);

$sql = "SELECT * FROM cars ORDER BY RAND()";
$result = $conn->query($sql);

if (isset($_POST["filter_option"]) && $_POST["filter_option"] !== "none") {
  $filter_option = $conn->real_escape_string($_POST["filter_option"]);
  $sql = "SELECT * FROM cars WHERE Make LIKE '$filter_option'";
} else {
  $sql = "SELECT * FROM cars ORDER BY RAND()";
}
$result = $conn->query($sql);

?>

<h1 style="text-align:center">Welcome To EV Car Rentals</h1>

<form name="filter" method="POST" style="text-align: center;">
    <select name="filter_option" id="filter_option" onchange="this.form.submit()">
        <option value="none" <?php if (!isset($_POST["filter_option"]) || $_POST["filter_option"] == "none") echo "selected"; ?>>None</option>
        <?php
        if ($make_result->num_rows > 0) {
            while ($row = $make_result->fetch_assoc()) {
                echo '<option value="' . $row["Make"] . '"';
                if (isset($_POST["filter_option"]) && $_POST["filter_option"] == $row["Make"]) {
                    echo " selected";
                }
                echo '>' . $row["Make"] . '</option>';
            }
        }
        ?>
    </select>
</form>


<main>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <a style="text-decoration: none" href=<?php echo "view-car.php?id=" . $row["CarID"]; ?>>
        <div class="card">
          <div class="card-item">
              <p style="font-size: 14px;" class="type"><?php echo "$" . $row["RentalRatePerDay"] . " per day"; ?></p>
               <p><b><?php echo '<img src="Images/CarImages/' . $row["Image"] . '" style="max-width: 150px;">'; ?></b></p>
              <p style="font-size: 20px; padding:1em;" class="topic_name"><?php echo $row["Make"]; ?></p>
              <p style="font-size: 12px; padding:1em;" class="description"><?php echo substr($row["Year"], 0, 100); ?></p>
          </div>
        </div>
    </a>
    <br>
<?php } ?>
</main>
</body>
</html>
