<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <title>User Profile</title>
    <style>
        body {
            background-color: #1c1c1c;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #00bcd4;
            margin-bottom: 20px;
        }

        .profile-container {
            width: 90%;
            margin: 40px auto;
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .table-container {
            width: 97%;
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        table.dataTable {
            width: 100%;
            border-collapse: collapse;
            background-color: #2c2c2c;
        }

        table.dataTable thead th {
            background-color: #00bcd4;
            color: white;
            padding: 10px;
            border-bottom: 2px solid #ddd;
            text-align: left;
        }

        table.dataTable tbody td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            color: #f5f5f5;
        }

        table.dataTable tbody tr:hover {
            background-color: #383838;
            cursor: pointer;
        }

        .general-button {
            background-color: #00bcd4;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .general-button:hover {
            background-color: #0097a7;
        }
        .profile-pic{
            width: 100px;
            height: 100px;
            border-radius: 20px;
        }
    </style>
</head>
<body>
<?php
include_once "header.php"; // Include the header
require_once "connection.php";

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION["email"])) {
    die("Error: You are not logged in. Please log in to view your profile.");
}

// Retrieve user information from session email
$email = $_SESSION["email"];

// Establish database connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare and execute query to get user details
$user_query = $conn->prepare("SELECT user_id, first_name, last_name, email, profile_picture FROM users WHERE email = ?");
$user_query->bind_param("s", $email);
$user_query->execute();
$user_result = $user_query->get_result();

// Prepare and execute query to get user bookings
$booking_query = $conn->prepare("SELECT * FROM bookings WHERE UserEmail = ?");
$booking_query->bind_param("s", $email);
$booking_query->execute();
$booking_result = $booking_query->get_result();

// Check for status message
$status_message = $_GET['status'] ?? '';
?>

<h1>User Profile</h1>

<div class="profile-container">
<?php if ($status_message === 'success'): ?>
        <p class="confirmation-message">Password changed successfully!</p>
    <?php endif; ?>

    <a href="change-password.php" class="general-button">Change Password</a>


    <?php if ($user_result->num_rows > 0): ?>
        <?php $user = $user_result->fetch_assoc(); ?>
        <div class="profile-info">
            <?php echo '<img src="Images/ProfileImages/'.htmlspecialchars($user['profile_picture']).'" class="profile-pic">'; ?>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['last_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p> 
            <!-- Password should not be displayed in plain text for security reasons -->
        </div>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>

    <h2>My Bookings</h2>

    <div class="table-container">
        <table id="bookingTable" class="display">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Car ID</th>
                    <th>Rental Date</th>
                    <th>Rental Duration</th>
                    <th>Distance Traveled</th>
                    <th>Charging Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($booking_result->num_rows > 0): ?>
                    <?php while ($row = $booking_result->fetch_assoc()): 
                        $distance = calculateDistance($row['CarID'], $row['RentalDate']);
                        $chargingCost = calculateChargingCost($distance);
                        echo '<tr>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . htmlspecialchars($row["BookingID"]) . '\'">' . htmlspecialchars($row["BookingID"]) . '</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . htmlspecialchars($row["BookingID"]) . '\'">' . htmlspecialchars($row["CarID"]) . '</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . htmlspecialchars($row["BookingID"]) . '\'">' . htmlspecialchars($row["RentalDate"]) . '</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . htmlspecialchars($row["BookingID"]) . '\'">' . htmlspecialchars($row["RentalDuration"]) . '</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . $row["BookingID"] . '\'">' . $distance . ' miles</div></td>';
                    echo '<td><div onclick="window.location.href=\'view-booking.php?BookingID=' . $row["BookingID"] . '\'">$' . number_format($chargingCost, 2) . '</div></td>';
                    echo '<td>
                            <a class="general-button" href="delete-booking.php?BookingID=' . $row["BookingID"] . '" onclick="return confirm(\'Are you sure you want to delete this booking?\');">Cancel</a>
                        </td>';
                    echo '</tr>';
                    ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#bookingTable').DataTable({
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var header = $(column.header());

                    var searchInput = $('<input type="text" class="form-control form-control-sm dt-input" placeholder="Search">')
                        .appendTo(header)
                        .on('keyup change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                });
            }
        });
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

<?php
// Close connections
$user_query->close();
$booking_query->close();
mysqli_close($conn);
?>

</body>
</html>
