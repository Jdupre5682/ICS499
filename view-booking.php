<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .wrapper {
            width: 60%;
            margin: 40px auto;
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            color: #00bcd4;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group label {
            color: #00bcd4;
            font-weight: bold;
        }

        .form-group p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #00bcd4;
            border-color: #00bcd4;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            display: block;
            width: 100%;
            margin-top: 30px;
        }

        .btn-primary:hover {
            background-color: #0097a7;
            border-color: #0097a7;
        }
    </style>
</head>

<body style="background-color: #1c1c1c">
    <?php
    // Check existence of BookingID parameter before processing
    if (isset($_GET["BookingID"])) {
        require_once "connection.php";
        include "header.php";

        $bookingID = $_GET["BookingID"];
        $carID = "";
        $userEmail = "";
        $rentalDate = "";
        $rentalDuration = "";
        $cardNumber = "";
        $cardExpiry = "";
        $cardCVV = "";

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        // Establish connection with database
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Set charset to utf-8
        $conn->set_charset("utf8");

        // Create SQL
        $sql = "SELECT * FROM bookings WHERE BookingID={$bookingID}";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $carID = $row["CarID"];
            $userEmail = $row["UserEmail"];
            $rentalDate = $row["RentalDate"];
            $rentalDuration = $row["RentalDuration"];
            $cardNumber = $row["CardNumber"];
            $cardExpiry = $row["CardExpiry"];
            $cardCVV = $row["CardCVV"];
        }
    }
    ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">Booking Details</h1>
                    <div class="form-group">
                        <label>Booking ID</label>
                        <p><b><?php echo $bookingID; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Car ID</label>
                        <p><b><?php echo $carID; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>User Email</label>
                        <p><b><?php echo $userEmail; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Rental Date</label>
                        <p><b><?php echo $rentalDate; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Rental Duration</label>
                        <p><b><?php echo $rentalDuration; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Card Number</label>
                        <p><b><?php echo $cardNumber; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Card Expiry</label>
                        <p><b><?php echo $cardExpiry; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Card CVV</label>
                        <p><b><?php echo $cardCVV; ?></b></p>
                    </div>
                    <?php if (
                        isset($_SESSION["permissions"]) &&
                        $_SESSION["permissions"] === "super"
                        ) {
                        echo '<a href="modify-booking.php?BookingID=<?php echo $bookingID; ?>" class="btn btn-primary">Modify</a>';
                        echo'<a href="bookings.php" class="btn btn-primary">Back</a>';
                    } ?>
                    <?php if (
                        isset($_SESSION["permissions"]) &&
                        $_SESSION["permissions"] === "visitor"
                        ) {
                        echo'<a href="profile.php" class="btn btn-primary">Back</a>';
                    } ?>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>
