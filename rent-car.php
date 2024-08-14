<?php
session_start();
require_once "connection.php";
include "header.php";

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Check if 'id' parameter is set in the URL
if (!isset($_GET['id'])) {
    die("Car ID not provided.");
}

$carID = $_GET['id'];
$userEmail = $_SESSION['email'];

// Initialize variables for form data
$rentalDate = $rentalDuration = $cardNumber = $cardExpiry = $cardCVV = "";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $rentalDate = $_POST['rentalDate'];
    $rentalDuration = $_POST['rentalDuration'];
    $cardNumber = $_POST['cardNumber'];
    $cardExpiry = $_POST['cardExpiry'];
    $cardCVV = $_POST['cardCVV'];

    //Hash the card number and card CVV (sha56 is the reccomended hash)
    $hash_cardNumber = hash('sha256', $cardNumber);
    $hash_cardCVV = hash('sha256', $cardCVV);

    // Prepare and bind the SQL statement
    $stmt = $con->prepare("INSERT INTO bookings (CarID, UserEmail, RentalDate, RentalDuration, CardNumber, CardExpiry, CardCVV) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $carID, $userEmail, $rentalDate, $rentalDuration, $hash_cardNumber, $cardExpiry, $hash_cardCVV);

    if ($stmt->execute()) {
        // Redirect with a success message
        echo "<script>
                alert('Booking successful!');
                window.location.href='index.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" style="background-color: #1c1c1c">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <title>Rent Car</title>
    <style>
        body {
            background-color: #1c1c1c;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 60%;
            margin: 40px auto;
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h2 {
            color: #00bcd4;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            padding-bottom: 20px;
        }

        .form-group label {
            color: #00bcd4;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #00bcd4;
            border-radius: 5px;
            background-color: #4b4b4b;
            color: #f5f5f5;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #0097a7;
        }
    </style>

</head>
<body>
    <div class="container">
        <h2>Rent Car</h2>
        <form action="rent-car.php?id=<?php echo $carID; ?>" method="POST" onsubmit="return validateCardExpiry()">
            <div class="form-group">
                <label for="rentalDate">Rental Date</label>
                <input type="date" id="rentalDate" name="rentalDate" required>
            </div>
            <div class="form-group">
                <label for="rentalDuration">Rental Duration (days)</label>
                <input type="number" id="rentalDuration" name="rentalDuration" required>
            </div>
            <div class="form-group">
                <label for="cardNumber">Card Number</label>
                <input type="text" id="cardNumber" name="cardNumber" required>
            </div>
            <div class="form-group">
                <label for="cardExpiry">Card Expiry Date</label>
                <input type="text" id="cardExpiry" name="cardExpiry" required placeholder="MM/YY">
                <div id="expiryError" class="error"></div>
            </div>
            <div class="form-group">
                <label for="cardCVV">Card CVV</label>
                <input type="text" id="cardCVV" name="cardCVV" required>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
        <script>
        function validateCardExpiry() {
            var cardExpiry = document.getElementById('cardExpiry').value;
            var expiryError = document.getElementById('expiryError');
            var pattern = /^(0[1-9]|1[0-2])\/[0-9]{2}$/;

            if (!pattern.test(cardExpiry)) {
                expiryError.textContent = 'Please enter the expiry date in MM/YY format.';
                return false; // Prevent form submission
            }

            expiryError.textContent = '';
            return true; // Allow form submission
        }
    </script>
    </div>
</body>
</html>
