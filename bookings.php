<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>
    <title>List of Bookings</title>
    <style>
        body {
            background-color: #1c1c1c;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #00bcd4;
            text-align: center;
        }

        .table-container {
            margin: 20px auto;
            width: 80%;
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        #bookingTable {
            width: 100%;
            border-collapse: collapse;
        }

        #bookingTable thead th,
        #bookingTable tbody td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #bookingTable thead th {
            background-color: #2c2c2c;
            color: white;
        }

        #bookingTable tbody tr:nth-child(even) {
            background-color: #333;
        }

        #bookingTable tbody tr:hover {
            background-color: #555;
        }

        .general-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            color: white;
            background-color: #00bcd4;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .general-button:hover {
            background-color: #0097a7;
        }
    </style>
</head>
<body>
<?php
include_once "header.php";
require_once "connection.php";

$loggedInUserEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : null;
?>

<h1>List of Bookings</h1>
<?php
if (isset($_SESSION["permissions"]) && ($_SESSION["permissions"] === "super")) {
    if (isset($_SESSION["first_name"])) {
        echo "<h1>Hello " . $_SESSION["first_name"] . "!</h1>";
    }
}
?>
<div class="table-container">
    <table id="bookingTable" class="display" cellspacing="0">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Car ID</th>
                <th>User Email</th>
                <th>Rental Date</th>
                <th>Rental Duration</th>
                <th>Distance Traveled</th>
                <th>Charging Cost</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            $sql = "SELECT * FROM bookings";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $distance = calculateDistance($row['CarID'], $row['RentalDate']);
                    $chargingCost = calculateChargingCost($distance);
                    
                    echo '<tr>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . $row["BookingID"] . '\'">' . $row["BookingID"] . '</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . $row["BookingID"] . '\'">' . $row["CarID"] . '</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . $row["BookingID"] . '\'">' . $row["UserEmail"] . '</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . $row["BookingID"] . '\'">' . $row["RentalDate"] . '</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . $row["BookingID"] . '\'">' . $row["RentalDuration"] . '</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . $row["BookingID"] . '\'">' . $distance . ' miles</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . $row["BookingID"] . '\'">$' . number_format($chargingCost, 2) . '</div></td>';
                    echo '<td>
                            <a class="general-button" href="modify-booking.php?BookingID=' . $row["BookingID"] . '">Modify</a>
                            <a class="general-button" href="delete-booking.php?BookingID=' . $row["BookingID"] . '" onclick="return confirm(\'Are you sure you want to delete this booking?\');">Delete</a>
                        </td>';
                    echo '</tr>';
                }
            } else {
                echo "<tr><td colspan='8'>0 results</td></tr>";
            }
            $result->close();
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $('#bookingTable').DataTable();
    });
</script>

<?php
function calculateDistance($carID, $rentalDate) {
    // Your logic to calculate distance based on carID and rentalDate
    return rand(50, 300); // Example random value
}

function calculateChargingCost($distance) {
    $costPerMile = 0.10; // Example cost per mile
    return $distance * $costPerMile;
}
?>
</body>
</html>
