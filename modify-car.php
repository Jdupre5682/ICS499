<?php
include "header.php";
require_once "connection.php";

$carID = $make = $model = $year = $licensePlate = $color = $batteryCapacity = $rangePerCharge = $rentalRatePerDay = $image = "";
$errors = [];

// Get the CarID from the URL query parameter if there is an ID
if (isset($_GET["id"])) {
    $carID = $_GET["id"];

    $query = "SELECT * FROM Cars WHERE CarID = $carID";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $make = $row["Make"];
        $model = $row["Model"];
        $year = $row["Year"];
        $licensePlate = $row["LicensePlate"];
        $color = $row["Color"];
        $batteryCapacity = $row["BatteryCapacity"];
        $rangePerCharge = $row["RangePerCharge"];
        $rentalRatePerDay = $row["RentalRatePerDay"];
        $image = $row["Image"];
    } else {
        $errors[] = "No such car found";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["CarID"])) {
    $carID = $_POST["CarID"];

    if ($carID != "none") {
        $query = "SELECT * FROM Cars WHERE CarID = $carID";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $make = $row["Make"];
            $model = $row["Model"];
            $year = $row["Year"];
            $licensePlate = $row["LicensePlate"];
            $color = $row["Color"];
            $batteryCapacity = $row["BatteryCapacity"];
            $rangePerCharge = $row["RangePerCharge"];
            $rentalRatePerDay = $row["RentalRatePerDay"];
            $image = $row["Image"];
        } else {
            $errors[] = "No such car found";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    if (empty($_POST["CarID"])) {
        $errors[] = "Car ID is required";
    } else {
        $carID = $_POST["CarID"];
    }

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

    if (!empty($_FILES["Image"]["name"])) { // If the file is not empty, add image into directory
        $target_dir = "Images/CarImages/";
        $target_file = $target_dir . basename($_FILES["Image"]["name"]);

        if (move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["Image"]["name"]);
        } else {
            $errors[] = "Sorry, there was an error uploading your image file.";
        }
    } else {
            $image = $row["Image"];
        }

    if (empty($errors)) {
        $color = $_POST["color"];

        $query = "UPDATE Cars SET 
                    Make='$make', 
                    Model='$model', 
                    Year= $year, 
                    LicensePlate='$licensePlate', 
                    Color='$color', 
                    BatteryCapacity=$batteryCapacity, 
                    RangePerCharge=$rangePerCharge, 
                    RentalRatePerDay=$rentalRatePerDay,
                    Image= '$image'
                  WHERE CarID=$carID";

        if ($con->query($query) === TRUE) {
            echo "<script>alert('Car details updated successfully'); window.location.href='index.php';</script>";
        } else {
            $errors[] = "Error updating record: " . $con->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <title>Modify Car</title>
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

        .form-container input[type="text"], .form-container input[type="number"], .form-container input[type="decimal"], .form-container select {
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
        function confirmModification() {
            return confirm("Are you sure you want to modify this car's details?");
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Modify Car</h1>
        <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>

        <?php if (!isset($_GET["id"]) || empty($_GET["id"])): ?>
        <form method="POST">
            <label for="CarID">Select Car ID</label>
            <select id="CarID" name="CarID" onchange="this.form.submit()">
                <option value="none">Select a Car</option>
                <?php
                $query = "SELECT CarID FROM Cars";
                $result = $con->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["CarID"] . '"' . ($carID == $row["CarID"] ? ' selected' : '') . '>' . $row["CarID"] . '</option>';
                }
                ?>
            </select>
        </form>
        <?php endif; ?>

        <?php if ($carID != "none" && $carID != ""): ?>
            <form method="POST" enctype="multipart/form-data" onsubmit="return confirmModification()">
            <input type="hidden" id="CarID" name="CarID" value="<?php echo $carID; ?>">

            <label for="make">Make</label>
            <input type="text" id="make" name="make" value="<?php echo $make; ?>" required>

            <label for="model">Model</label>
            <input type="text" id="model" name="model" value="<?php echo $model; ?>" required>

            <label for="year">Year</label>
            <input type="number" id="year" name="year" value="<?php echo $year; ?>" required>

            <label for="licensePlate">License Plate</label>
            <input type="text" id="licensePlate" name="licensePlate" value="<?php echo $licensePlate; ?>" required>

            <label for="color">Color</label>
            <input type="text" id="color" name="color" value="<?php echo $color; ?>">

            <label for="batteryCapacity">Battery Capacity</label>
            <input type="number" step="0.01" id="batteryCapacity" name="batteryCapacity" value="<?php echo $batteryCapacity; ?>" required>

            <label for="rangePerCharge">Range Per Charge</label>
            <input type="number" step="0.01" id="rangePerCharge" name="rangePerCharge" value="<?php echo $rangePerCharge; ?>" required>

            <label for="rentalRatePerDay">Rental Rate Per Day</label>
            <input type="number" step="0.01" id="rentalRatePerDay" name="rentalRatePerDay" value="<?php echo $rentalRatePerDay; ?>" required>

            <label for="image">Upload Car Model Image</label>
            <input id="image" name="Image" class="input" type="file"/><br><br>

            <input type="submit" name="update" value="Modify Car">
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
