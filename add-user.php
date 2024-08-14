<?php
include "header.php";
require_once "connection.php";

$first_name = $last_name = $email = $password = $permissions = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["first_name"])) {
        $errors[] = "A first name is required";
    } else {
        $first_name = $_POST["first_name"];
    }

    if (empty($_POST["last_name"])) {
        $errors[] = "A last name is required";
    } else {
        $last_name = $_POST["last_name"];
    }

    if (empty($_POST["email"])) {
        $errors[] = "An email is required";
    } else {
        $email = $_POST["email"];
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $errors[] = "A password is required";
    } else {
        $password = $_POST["password"];
        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    }

    if (empty($_POST["permissions"]) || $_POST["permissions"] == "none") {
        $errors[] = "Please set permissions for this user.";
    } else {
        $permissions = $_POST["permissions"];
        // Validate permissions
        $valid_permissions = ['super', 'visitor'];
        if (!in_array($permissions, $valid_permissions)) {
            $errors[] = "Invalid permissions selected";
        }
    }

    if (empty($errors)) {
        $stmt = $con->prepare("INSERT INTO users (first_name, last_name, email, password, permissions) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $permissions);

        if ($stmt->execute()) {
            echo "<script>alert('New user added successfully');</script>";
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
    <title>Add User</title>
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

        .form-container input[type="text"], .form-container input[type="password"], .form-container select {
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
            margin-top: 30px;
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
        function confirmAddition() {
            return confirm("Are you sure you want to add this user?");
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Add New User</h1>
        <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
        <form method="POST" onsubmit="return confirmAddition()">
            <label for="first_name">First name</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last name</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="permissions">Permissions</label>
            <select id="permissions" name="permissions" required>
                <option value="none" disabled selected>Select a permission</option>
                <option value="super">Super</option>
                <option value="visitor">Visitor</option>
            </select>

            <input type="submit" value="Add User">
        </form>
    </div>
</body>
</html>
