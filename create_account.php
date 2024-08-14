<?php



include("connection.php");
include("functions.php");
include("header.php");

$createAccountStatus = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user_name = $_POST['email'];
    $password = $_POST['password'];
    $displayname = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $hash_pass = password_hash($password, PASSWORD_DEFAULT);

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name) && !empty($last_name)) {
                // Check if email already exists
                $check_query = "SELECT * FROM users WHERE email = ?";
                $stmt = $con->prepare($check_query);
                $stmt->bind_param("s", $user_name);
                $stmt->execute();
                $result = $stmt->get_result();
        
                if ($result->num_rows > 0) {
                    // Email already exists
                    $createAccountStatus = "An account with this email already exists. Please login or use a different email.";
                } else {
                $profile_picture = 'profile.png';

                // Insert user data into the database
                $query = "INSERT INTO users (email, password, first_name, last_name, profile_picture) VALUES (?, ?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sssss", $user_name, $hash_pass, $displayname, $last_name, $profile_picture);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    // Account created successfully
                    $createAccountStatus = "Account created successfully. Redirecting you to login page, please wait..";
                } else {
                    $createAccountStatus = "There was an error creating your account. Please try again.";
                }
            }
        } else {
            $createAccountStatus = "Please fill out all required fields correctly.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<link href="./styles.css" rel="stylesheet" type="text/css" media="all" />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <title>Create Account</title>
</head>

<body>

    <style type="text/css">
        #bg {
            background-image: url("Images/evCarbackground.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        body,
        html {
            height: 100vh;
            margin: auto;
            overflow: hidden;
        }

        #text {

            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            width: 100%;
        }

        #button {

            padding: 10px;
            width: 100px;
            font-weight: 600;
            color: white;
            background-color: #0097a7;
            border: none;
            border-radius: 20px;

        }

        #box {

            background-color: #353839;
            position: fixed;
            left: 40%;
            right: 50%;
            top: 60%;
            transform: translateY(-50%);
            width: 300px;
            padding: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 8px;

        }

        .status_message {
            font-weight: 600;
            color: #FC4A1A;
        }
    </style>
    <script>
    if ("<?php echo $createAccountStatus; ?>" == "Account created successfully. Redirecting you to login page, please wait..") {
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 4000); // 3 seconds delay
    }
    </script>

    <div id="bg">
        <div id="box">

            <img src="Images/logo1.png" width=150px height=150px>

            <form method="POST">
                <div style="font-size: 20px; margin: 10px; color:#FFFFFF;">Create Account</div>
                <input id="text" type="text" name="email" placeholder="Email"><br><br>
                <input id="text" type="password" name="password" placeholder="Password"><br><br>
                <input id="text" type="text" name="first_name" placeholder="First Name"><br><br>
                <input id="text" type="text" name="last_name" placeholder="Last Name"><br><br>

                <input id="button" type="submit" value="SIGN UP"><br><br>

                <a href="login.php" style="color:#FFFFFF">Login</a><br><br>

                <span class="status_message"><?php echo $createAccountStatus; ?></span>

            </form>
        </div>
    </div>

</body>

</html>