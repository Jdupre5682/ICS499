<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .wrapper {
            width: 60%;
            margin: 40px auto;
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            color: #00bcd4;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group label {
            color: #00bcd4;
            font-weight: bold;
        }

        .form-group p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #00bcd4;
            border-color: #00bcd4;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            display: block;
            width: 100%;
            margin-top: 30px;
        }

        .btn-primary:hover {
            background-color: #0097a7;
            border-color: #0097a7;
        }
    </style>
</head>

<body style="background-color: #1c1c1c">
    <?php
    // Check existence of id parameter before processing
    if (isset($_GET["id"])) {
        require_once "connection.php";
        include "header.php";

        $user_id = $_GET["id"];
        $first_name = "";
        $last_name = "";
        $email = "";
        $password = "";
        $permissions = "";
        $profile_picture = "";

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        // Establish connection with database
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Set charset to utf-8
        $conn->set_charset("utf8");

        // Create SQL
        $sql = "SELECT * FROM users WHERE user_id={$user_id}";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $user_id = $row["user_id"];
            $first_name = $row["first_name"];
            $last_name = $row["last_name"];
            $email = $row["email"];
            $password = $row["password"];
            $permissions = $row["permissions"];
            $profile_picture = $row["profile_picture"];
        }
    }
    ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3"><?php echo $first_name . ' ' . $last_name; ?></h1>
                    <div class="form-group">
                    <p><b><?php echo '<img src="Images/ProfileImages/'.$profile_picture.'" style="max-width: 100px;" alt="Profile Picture">'; ?></b></p>
                        <label>User ID</label>
                        <p><b><?php echo $user_id; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p><b><?php echo $email; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <p><b><?php echo $password; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Current Permissions</label>
                        <p><b><?php echo $permissions; ?></b></p>
                    </div>
                    
                    <a href="modify-user.php?id=<?php echo $user_id; ?>" class="btn btn-primary">Modify</a></p>
                    <p><a href="user-list.php" class="btn btn-primary">Back</a>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</body>

</html>
