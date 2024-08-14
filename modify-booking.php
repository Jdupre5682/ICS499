<?php
// modify-booking.php

include_once "header.php";
require_once "connection.php";

if (isset($_GET['BookingID'])) {
    $bookingID = $_GET['BookingID'];
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Fetch the booking details
    $sql = "SELECT * FROM bookings WHERE BookingID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="images/logo1.png" type="image/x-icon">
            <title>Modify Booking</title>
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

                .form-container {
                    width: 90%;
                    margin: 40px auto;
                    background-color: #2c2c2c;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                }

                form {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                label {
                    margin: 10px 0;
                    font-weight: bold;
                    color: #00bcd4;
                }

                input {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 20px;
                    border: none;
                    border-radius: 5px;
                    background-color: #4b4b4b;
                    color: #f5f5f5;
                }

                button {
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

                button:hover {
                    background-color: #0097a7;
                }
            </style>

        <script>
        function confirmModification() {
            return confirm("Are you sure you want to modify this booking's details?");
        }
        </script>

        </head>
        <body>
        <div class="form-container">
            <h1>Modify Booking</h1>
            <form method="post" action="modify-booking.php" onsubmit="return confirmModification()">
                <input type="hidden" name="BookingID" value="<?php echo $row['BookingID']; ?>">
                <label for="CarID">Car ID:</label>
                <input type="text" name="CarID" value="<?php echo $row['CarID']; ?>">
                <label for="UserEmail">User Email:</label>
                <input type="email" name="UserEmail" value="<?php echo $row['UserEmail']; ?>">
                <label for="RentalDate">Rental Date:</label>
                <input type="date" name="RentalDate" value="<?php echo $row['RentalDate']; ?>">
                <label for="RentalDuration">Rental Duration:</label>
                <input type="text" name="RentalDuration" value="<?php echo $row['RentalDuration']; ?>">
                <label for="CardNumber">Card Number:</label>
                <input type="text" name="CardNumber" value="<?php echo $row['CardNumber']; ?>">
                <label for="CardExpiry">Card Expiry:</label>
                <input type="text" name="CardExpiry" value="<?php echo $row['CardExpiry']; ?>">
                <label for="CardCVV">Card CVV:</label>
                <input type="text" name="CardCVV" value="<?php echo $row['CardCVV']; ?>">
                <button type="submit" name="submit">Save Changes</button>
            </form>
        </div>
        <?php
    } else {
        echo "<p>Booking not found.</p>";
    }
    $stmt->close();
    $conn->close();
} elseif (isset($_POST['submit'])) {
    // Update booking details
    $bookingID = $_POST['BookingID'];
    $carID = $_POST['CarID'];
    $userEmail = $_POST['UserEmail'];
    $rentalDate = $_POST['RentalDate'];
    $rentalDuration = $_POST['RentalDuration'];
    $cardNumber = $_POST['CardNumber'];
    $cardExpiry = $_POST['CardExpiry'];
    $cardCVV = $_POST['CardCVV'];

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    $sql = "UPDATE bookings SET CarID = ?, UserEmail = ?, RentalDate = ?, RentalDuration = ?, CardNumber = ?, CardExpiry = ?, CardCVV = ? WHERE BookingID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssi", $carID, $userEmail, $rentalDate, $rentalDuration, $cardNumber, $cardExpiry, $cardCVV, $bookingID);

    if ($stmt->execute()) {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Booking Updated</title>
            <style>
                body {
                    background-color: #1c1c1c;
                    color: #f5f5f5;
                    font-family: Arial, sans-serif;
                    text-align: center;
                    padding: 20px;
                }
                button {
                    background-color: #00bcd4;
                    border: none;
                    color: white;
                    padding: 10px 20px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 20px 2px;
                    cursor: pointer;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }
                button:hover {
                    background-color: #0097a7;
                }
            </style>
        </head>
        <body>
            <p>Booking updated successfully.</p>
            <form action='bookings.php' method='get'>
                <button type='submit'>Go Back to Bookings</button>
            </form>
        </body>
        </html>";
    } else {
        echo "<p>Error updating booking.</p>";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid request.</p>";
}
?>
</body>
</html>
