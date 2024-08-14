<?php
include "header.php";
require_once "connection.php";

$make = $model = $year = $licensePlate = $color = $batteryCapacity = $rangePerCharge = $rentalRatePerDay = $image = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["make"])) {
        $errors[] = "Make is required";
    } else {
        $make = $_POST["make"];
    }

    if (empty($_POST["model"])) {
        $errors[] = "Model is required";
    } else {
        $model = $_POST["model"];
    }

    if (empty($_POST["year"])) {
        $errors[] = "Year is required";
    } else {
        $year = $_POST["year"];
    }

    if (empty($_POST["licensePlate"])) {
        $errors[] = "License Plate is required";
    } else {
        $licensePlate = $_POST["licensePlate"];
    }

    if (empty($_POST["batteryCapacity"])) {
        $errors[] = "Battery Capacity is required";
    } else {
        $batteryCapacity = $_POST["batteryCapacity"];
    }

    if (empty($_POST["rangePerCharge"])) {
        $errors[] = "Range Per Charge is required";
    } else {
        $rangePerCharge = $_POST["rangePerCharge"];
    }

    if (empty($_POST["rentalRatePerDay"])) {
        $errors[] = "Rental Rate Per Day is required";
    } else {
        $rentalRatePerDay = $_POST["rentalRatePerDay"];
    }

    if (empty($_FILES["Image"]["name"])) { // If the file is empty
        $errors[] = "Please upload an image.";
    } else { // if it's not empty
        $target_dir = "Images/CarImages/";
        $target_file = $target_dir . basename($_FILES["Image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["Image"]["tmp_name"]);

        if ($check === false || !in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $errors[] = "File is not an image.";
        } elseif (!move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)) {
            $errors[] = "Sorry, there was an error uploading your image file.";
        } else {
            $image = basename($_FILES["Image"]["name"]);
        }
    }

    if (empty($errors)) {
        $color = $_POST["color"];

        $stmt = $con->prepare("INSERT INTO Cars (Make, Model, Year, LicensePlate, Color, BatteryCapacity, RangePerCharge, RentalRatePerDay, Image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissddds", $make, $model, $year, $licensePlate, $color, $batteryCapacity, $rangePerCharge, $rentalRatePerDay, $image);

        if ($stmt->execute()) {
            echo "<script>alert('New car added successfully');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Car</title>
    <style>
        body {
            background-color: #1c1c1c;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .form-container {
            width: 50%;
            margin: 40px auto;
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .form-container h1 {
            text-align: center;
            color: #00bcd4;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-top: 10px;
        }

        .form-container input[type="text"], .form-container input[type="number"], .form-container input[type="decimal"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #00bcd4;
            border-radius: 5px;
            background-color: #4b4b4b;
            color: #f5f5f5;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0097a7;
        }

        .form-container .error {
            color: #f44336;
            font-weight: bold;
        }
    </style>
    <script>
        function confirmSubmission() {
            return confirm("Are you sure you want to add this car?");
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Add New Car</h1>
        <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
        <form method="POST" enctype="multipart/form-data" onsubmit="return confirmSubmission()">
            <label for="make">Make</label>
            <input type="text" id="make" name="make" required>

            <label for="model">Model</label>
            <input type="text" id="model" name="model" required>

            <label for="year">Year</label>
            <input type="number" id="year" name="year" required>

            <label for="licensePlate">License Plate</label>
            <input type="text" id="licensePlate" name="licensePlate" required>

            <label for="color">Color</label>
            <input type="text" id="color" name="color">

            <label for="batteryCapacity">Battery Capacity</label>
            <input type="number" step="0.01" id="batteryCapacity" name="batteryCapacity" required>

            <label for="rangePerCharge">Range Per Charge</label>
            <input type="number" step="0.01" id="rangePerCharge" name="rangePerCharge" required>

            <label for="rentalRatePerDay">Rental Rate Per Day</label>
            <input type="number" step="0.01" id="rentalRatePerDay" name="rentalRatePerDay" required>

            <label for="image">Upload Car Model Image</label>
            <input id="image" name="Image" class="input" type="file"/><br><br>

            <input type="submit" value="Add Car">
        </form>
    </div>
</body>
</html>
