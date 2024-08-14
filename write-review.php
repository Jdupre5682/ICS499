<?php
include "header.php";
require_once "connection.php";

$car_id = $user_id = $title = $body = $rating = $posted_by = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = $_POST['car_id'];
    $user_id = $_SESSION['user_id'];


    if (empty($_POST["title"])) {
        $errors[] = "A title for the review is required";
    } else {
        $title = $_POST["title"];
    }

    if (empty($_POST["body"])) {
        $errors[] = "A comment is required";
    } else {
        $body = $_POST["body"];
    }

    if (empty($_POST["rating"])) {
        $errors[] = "A rating is required";
    } else {
        $rating = $_POST["rating"];
    }

    // Format the date as 'Y-m-d'
    $posted_by = date('Y-m-d'); // Current date in 'YYYY-MM-DD' format

    // $title = $_POST['title'];
    // $body = $_POST['body'];
    // $rating = $_POST['rating'];

    $sql = "INSERT INTO reviews (CarID, UserID, Title, Body, Rating, PostedBy) 
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("iissis", $car_id, $user_id, $title, $body, $rating, $posted_by);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Review submitted successfully!";
            header("Location: view-car.php?id=" . $car_id);
            exit;
        } else {
            echo "Error: Could not submit review.";
        }

        $stmt->close();
    } else {
        echo "Error: " . $con->error;
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/logo1.png" type="image/x-icon">   
    <title>Write a Review</title>
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

        .form-container input[type="text"], .form-container input[type="number"], .form-container input[type="decimal"] {
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

        #body {
            width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 20px;
        border: 1px solid #00bcd4;
        border-radius: 5px;
        background-color: #4b4b4b;
        color: #f5f5f5;
        resize: vertical; /* Allows vertical resizing only */
        font-family: Arial, sans-serif;
}
    </style>
</head>
<body>
    <div class="form-container">
    <h1 class="mt-5">Write a Review</h1>
    <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
        <form action="write-review.php" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="body">Review</label>
                <textarea name="body" id="body" class="form-control" rows="5" maxlength="400" required></textarea>
            </div>
            <div class="form-group">
                <label for="rating">Rating (1-5)</label>
                <input type="number" step="0.5" name="rating" id="rating" class="form-control" min="1" max="5" maxlength="4" required/>
            </div>
            <input type="hidden" name="car_id" value="<?php echo $_GET['car_id']; ?>">
            <!-- <input type="hidden" name="posted_by" value="<?php echo date('Y-m-d H:i:s'); ?>"> -->

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
</body>
</html>