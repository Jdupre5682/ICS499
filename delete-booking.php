<?php
include "header.php";
require_once "connection.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["BookingID"])) {
    $bookingID = $_GET["BookingID"];
    
    // Check if the Booking ID exists in the database
    $query = "SELECT * FROM bookings WHERE BookingID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $bookingID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $errors[] = "No such booking was found";
    } else {
        // Start a transaction
        $con->begin_transaction();
        try {
            // Delete the booking record from the bookings table
            $query = "DELETE FROM bookings WHERE BookingID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $bookingID);
            $stmt->execute();

            // Commit the transaction
            $con->commit();

            // Determine the redirect URL
            $redirectUrl = 'bookings.php'; // Default URL
            if (isset($_SESSION['referrer'])) {
                $referrer = parse_url($_SESSION['referrer'], PHP_URL_PATH);
                if (strpos($referrer, 'profile.php') !== false) {
                    $redirectUrl = 'profile.php';
                } else if (strpos($referrer, 'bookings.php') !== false) {
                    $redirectUrl = 'bookings.php';
                }
                // Clear the referrer session after use
                unset($_SESSION['referrer']);
            }

            // Provide feedback and redirect to the appropriate page after 2 seconds
            echo "<script>
                alert('Booking deleted successfully');
                setTimeout(function() {
                    window.location.href='$redirectUrl';
                }, 2000);
            </script>";
        } catch (Exception $e) {
            // Rollback the transaction if something failed
            $con->rollback();
            $errors[] = "Error deleting record: " . $con->error;
        }
    }
} else {
    // Handle error: Booking ID not provided
    $errors[] = "Booking ID is required.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <title>Delete Booking</title>
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

        .form-container .error {
            color: #f44336;
            font-weight: bold;
        }
    </style>

        <script>
        function confirmModification() {
            return confirm("Are you sure you want to delete this booking?");
        }
        </script>

</head>
<body>
    <div class="form-container">
        <h1>Delete Booking</h1>
        <p style="text-align: center;">Processing..</p>
        <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
