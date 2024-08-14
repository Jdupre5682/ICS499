<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Help</title>
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>
    <style>
        body {
    background-color: #1c1c1c;
    color: #f5f5f5;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.wrapper {
    width: 70%;
    margin: 0 auto;
    padding: 20px;
    background-color: #2c2c2c;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

div {
    padding-left: 10%;
    padding-right: 10%;
}

h1 {
    text-align: center;
    color: #00bcd4;
    margin-top: 20px;
    margin-bottom: 20px;
}

h2 {
    color: #00bcd4;
    margin-top: 20px;
    margin-bottom: 10px;
}

p {
    color: #f5f5f5;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.header {
    padding: 20px;
    background-color: #00bcd4;
    text-align: center;
    border-radius: 10px;
    margin-bottom: 20px;
}

.header a {
    color: white;
    text-decoration: none;
    font-size: 24px;
    font-weight: bold;
}

.header a:hover {
    text-decoration: underline;
}

.container {
    padding: 20px;
    background-color: #2c2c2c;
    border-radius: 10px;
}

.footer {
    padding: 10px;
    text-align: center;
    background-color: #00bcd4;
    color: white;
    position: fixed;
    width: 100%;
    bottom: 0;
}

    </style>
</head>

<body style="background-color: #1c1c1c">
<?php
    include "header.php";
    ?>
    <div class="container">
        <h1>User Guide</h1>
        <div class="section">
            <h2>Creating an Account</h2>
            <p>To create an account:</p>
            <ol>
                <li>Click on the "Sign Up" button on the homepage.</li>
                <li>Fill out the registration form with your details (name, email, password).</li>
                <li>Click "Submit" to complete the registration.</li>
                <li>You will receive a confirmation email. Follow the instructions in the email to activate your account.</li>
            </ol>
        </div>
        <div class="section">
            <h2>Renting a Car</h2>
            <p>To rent a car:</p>
            <ol>
                <li>Log in to your account.</li>
                <li>Navigate to the "Book a Car" section.</li>
                <li>Select the car you wish to rent from the list.</li>
                <li>Choose your rental dates and any additional options.</li>
                <li>Click "Book Now" to complete the reservation.</li>
                <li>Review the booking details and confirm your reservation.</li>
            </ol>
        </div>
        <div class="section">
            <h2>Managing Your Bookings</h2>
            <p>To view or manage your bookings:</p>
            <ol>
                <li>Log in to your account.</li>
                <li>Go to the "My Bookings" page.</li>
                <li>Here you can view details of your current and past bookings.</li>
                <li>You can also cancel or modify bookings if allowed.</li>
            </ol>
        </div>
    </div>
</body>

</html>