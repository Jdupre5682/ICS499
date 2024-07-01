<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Car</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./styles.css" rel="stylesheet" type="text/css" media="all" />
    <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="icon" href="/images/favicon.png" type="image/x-icon">
    <style>
        .wrapper {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>

<body style="background-color: #1c1c1c">
    <?php
    // Check existence of id parameter before processing
    if (isset($_GET["id"])) {
        require_once "connection.php";
        include "header.php";

        $car_id = $_GET["id"];
        $car_image = "";
        $car_make = "";
        $car_model = "";
        $car_year = "";
        $car_license_plate = "";
        $car_color = "";
        $car_battery_capacity = "";
        $car_range_per_charge = "";
        $car_rental_rate_per_day = "";

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        // Establish connection with database
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Set charset to utf-8
        $conn->set_charset("utf8");

        // Create SQL
        $sql = "SELECT * FROM cars WHERE CarID={$car_id}";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $car_id = $row["CarID"];
            $car_image = $row["Image"];
            $car_make = $row["Make"];
            $car_model = $row["Model"];
            $car_year = $row["Year"];
            $car_license_plate = $row["LicensePlate"];
            $car_color = $row["Color"];
            $car_battery_capacity = $row["BatteryCapacity"];
            $car_range_per_charge = $row["RangePerCharge"];
            $car_rental_rate_per_day = $row["RentalRatePerDay"];
        }
    }
    ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <p><b><?php echo '<img src="images/'.$car_image.'" style="max-width: 300px;">'; ?></b></p>
                    </div>
                    <h1 class="mt-5 mb-3"><?php echo $car_make . ' ' . $car_model; ?></h1>
                    <div class="form-group">
                        <label>Year</label>
                        <p><b><?php echo $car_year; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>License Plate</label>
                        <p><b><?php echo $car_license_plate; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Color</label>
                        <p><b><?php echo $car_color; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Battery Capacity</label>
                        <p><b><?php echo $car_battery_capacity; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Range Per Charge</label>
                        <p><b><?php echo $car_range_per_charge; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Rental Rate Per Day</label>
                        <p><b><?php echo $car_rental_rate_per_day; ?></b></p>
                    </div>
                    
                    <p><a href="index.php" class="btn btn-primary">Back</a>
                    
                    
                </div>
            </div>
        </div>
    </div>
</body>

</html>
