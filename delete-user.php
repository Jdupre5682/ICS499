<?php
include "header.php";
require_once "connection.php";

$user_id = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["user_id"])) {
        $errors[] = "User ID is required";
    } else {
        $user_id = $_POST["user_id"];
    }

    if (empty($errors)) {
        // Check if the user_id ID exists in the database
        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $result = $con->query($query);

        if ($result->num_rows == 0) {
            $errors[] = "No such user was found";
        } else {
            // Start a transaction
            $con->begin_transaction();
            try {

                // Delete the user record from the users table
                $query = "DELETE FROM users WHERE user_id = $user_id";
                $con->query($query);

                // Commit the transaction
                $con->commit();

                echo "<script>alert('User deleted successfully'); window.location.href='user-list.php';</script>";
            } catch (Exception $e) {
                // Rollback the transaction if something failed
                $con->rollback();
                $errors[] = "Error deleting record: " . $con->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <title>Delete User</title>
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

        .form-container input[type="text"] {
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
        function confirmDeletion() {
            return confirm("Are you sure you want to delete this user?");
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Delete User</h1>
        <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
        <form method="POST" onsubmit="return confirmDeletion()">
            <label for="user_id">User ID</label>
            <input type="text" id="user_id" name="user_id" required>

            <input type="submit" value="Delete User">
        </form>
    </div>
</body>
</html>
