<?php
include("connection.php");
include("functions.php");
include("header.php");

$loginAttemptStatus = "";
$isAdmin = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

        //read from database
        $query = "SELECT * FROM users where email = '$user_name' limit 1";
        $result = mysqli_query($con, $query);

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if (password_verify($password, $user_data['password']) || $user_data['password'] == $password) {
                    $loginAttemptStatus = "Login Successful";

                    echo "Login successful";

                    $_SESSION['user_id'] = $user_data['user_id'];
                    $_SESSION['permissions'] = $user_data['permissions'];
                    $_SESSION['first_name'] = $user_data['first_name']; 
                    $_SESSION['email'] = $user_data['email'];
                    
                    if ($user_data['permissions'] == "admin") {
                        $isAdmin = true;
                        $isUser = false;
                    } 
                    if ($user_data['permissions'] == "user") {
                        $isAdmin = false;
                        $isUser = true;
                    }

                    header("Location: index.php");
                    die;
                }
            }
        }

        $loginAttemptStatus = "Invalid Credentials";
    } else {
        // echo "Account Information Not Accepted.";
        $loginAttemptStatus = "Invalid Credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <title>Login</title>
    <style type="text/css">
    body,
html {
    height: 100%;
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #1c1c1c;
    color: #f5f5f5;
}

#bg {
    background-image: url("images/evCarbackground.jpg");
    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
}

#box {
    background-color: rgba(44, 44, 44, 0.9);
    padding: 40px;
    width: 320px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5), 0 6px 20px rgba(0, 0, 0, 0.5);
    text-align: center;
}

#box img {
    width: 100%;
    margin-bottom: 20px;
}

#text {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #00bcd4;
    border-radius: 5px;
    background-color: #2c2c2c;
    color: #f5f5f5;
    box-sizing: border-box;
}

#button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    background-color: #00bcd4;
    color: white;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

#button:hover {
    background-color: #0097a7;
    transform: translateY(-2px);
}

a {
    color: #00bcd4;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
    color: #f5f5f5;
}

.status_message {
    font-weight: 600;
    color: #fc4a1a;
    margin-top: 10px;
}

</style>

</head>

<body>
    <div id="bg">
        <div id="box">
            <!-- <img src="images/EV-Rentals_Portal.png" alt="EV Rentals Portal"> -->
            <form method="POST">
                <div style="font-size: 24px; margin-bottom: 20px; color: #FFFFFF">Login</div>
                <input id="text" type="text" name="email" placeholder="Email" required><br>
                <input id="text" type="password" name="password" placeholder="Password" required><br>
                <input id="button" type="submit" value="LOGIN"><br>
                <a href="create_account.php">Create Account</a><br>
                <span class="status_message"><?php echo $loginAttemptStatus; ?></span>
            </form>
        </div>
    </div>
</body>

</html>
