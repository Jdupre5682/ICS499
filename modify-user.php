<?php
include "header.php";
require_once "connection.php";

$user_id = $first_name = $last_name = $email = $password = $permissions = "";
$errors = [];

// Get the user_id from the URL query parameter if there is an ID
if (isset($_GET["id"])) {
    $user_id = $_GET["id"];

    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];
        $email = $row["email"];
        $password = $row["password"];
        $permissions = $row["permissions"];
    } else {
        $errors[] = "No such user found";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];

    if ($user_id != "none") {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $first_name = $row["first_name"];
            $last_name = $row["last_name"];
            $email = $row["email"];
            $password = $row["password"];
            $permissions = $row["permissions"];
        } else {
            $errors[] = "No such user was found.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    if (empty($_POST["user_id"])) {
        $errors[] = "User ID is required";
    } else {
        $user_id = $_POST["user_id"];
    }

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
        $errors[] = "Email is required";
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $errors[] = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    if (empty($_POST["permissions"])) {
        $errors[] = "Permissions is required";
    } else {
        $permissions = $_POST["permissions"];
    }

    if (empty($errors)) {
    // Check if a new password is provided
    if (!empty($password)) {
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET 
                first_name=?, 
                last_name=?, 
                email=?, 
                password=?,
                permissions=?
              WHERE user_id=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $hashed_pass, $permissions, $user_id);
    } else {
    // No new password provided, so don't include password in the query
        $query = "UPDATE users SET 
                first_name=?, 
                last_name=?, 
                email=?,
                permissions=?
              WHERE user_id=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssi", $first_name, $last_name, $email, $permissions, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('User details updated successfully'); window.location.href='user-list.php';</script>";
    } else {
        $errors[] = "Error updating record: " . $stmt->error;
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modify User</title>
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
        function confirmModification() {
            return confirm("Are you sure you want to modify this user's details?");
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Modify User</h1>
        <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
        <!-- If there isn't an id from the get method, proceed with a default dropdown -->
        <?php if (!isset($_GET["id"]) || empty($_GET["id"])): ?>
        <form method="POST">
            <label for="user_id">Select User ID</label>
            <select id="user_id" name="user_id" onchange="this.form.submit()">
                <option value="none">Select a User</option>
                <?php
                $query = "SELECT user_id FROM users";
                $result = $con->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["user_id"] . '"' . ($user_id == $row["user_id"] ? ' selected' : '') . '>' . $row["user_id"] . '</option>';
                }
                ?>
            </select>
        </form>
        <?php endif; ?>

        <?php if ($user_id != "none" && $user_id != ""): ?>
        <form method="POST" onsubmit="return confirmModification()">
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

            <label for="first_name">First name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>

            <label for="last_name">Last name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>

            <label for="permissions">Permissions</label>
            <select id="permissions" name="permissions" required>
                <option value="<?php echo $permissions; ?>">(Currently Selected) <?php echo $permissions; ?></option>
                <?php
                if ($permissions == "super") {
                    echo "<option value='visitor'>visitor</option>";
                } else {
                    echo "<option value='super'>super</option>";
                }
                ?>
            </select>
            <br><br>

            <input type="submit" name="update" value="Modify User">
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
