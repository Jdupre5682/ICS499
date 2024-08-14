<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Car</title>
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

        .reviews-container{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 10px;
        }

        .reviews-header{    
            /* display: flex; */
            text-align: center;
            font-size: 30px;
        }

        .reviews-card {
            background-color: #2c2c2c;
            border: 1px solid #00bcd4;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            margin: 10px;
            width: 350px;
            /* text-align: center; */
            overflow: hidden;
            position: relative;
        }

        .reviews-item {
            padding: 10px;
        }

        .review-profile-header{
            display: grid;
            grid-template-columns: 100px 1fr;
        }

        .reviews-item .review-userpfp {
            width: 100px;
            height: 100px;
            border-radius: 20px;
        }

        .reviews-item .review-user {
            grid-row-start: 1;
            grid-column-start: 2;
            padding: 1rem;
            font-weight: bold;
            font-size: 16px;
            margin-top: 0.5rem;
        }

        .reviews-item .review-rating {
            grid-column-start: 2;
            grid-row-start: 1;
            margin-top: 2rem;
            font-size: 14px;
            color: white;
            padding:1rem;
        }

        .reviews-item .review-postedby{
            grid-column-start: 2;
            grid-row-start: 1;
            margin-top: 4.5rem;
            font-size: 10px;
            color: #b0b0b0;
            padding-left:1rem;
        }

        .reviews-item .review-title {
            font-size: 20px;
            padding-top: 10px;
            margin-left: 5px;
        }

        .reviews-item .review-body {
            font-weight: bold;
            color: #00bcd4;
            font-size: 14px;
            margin-left: 5px;
            margin-top: -10px;
        }



    </style>
</head>

<body style="background-color: #1c1c1c">
    <?php
    // Check existence of id parameter before processing
    if (isset($_GET["id"])) {
        require_once "connection.php";
        include "header.php";

        $car_id = $_GET["id"];
        $car_image = "";
        $car_make = "";
        $car_model = "";
        $car_year = "";
        $car_color = "";
        $car_battery_capacity = "";
        $car_range_per_charge = "";
        $car_rental_rate_per_day = "";

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        // Establish connection with database
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Set charset to utf-8
        $conn->set_charset("utf8");

        // Create SQL
        $sql = "SELECT * FROM cars WHERE CarID={$car_id}";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $car_id = $row["CarID"];
            $car_image = $row["Image"];
            $car_make = $row["Make"];
            $car_model = $row["Model"];
            $car_year = $row["Year"];
            $car_color = $row["Color"];
            $car_battery_capacity = $row["BatteryCapacity"];
            $car_range_per_charge = $row["RangePerCharge"];
            $car_rental_rate_per_day = $row["RentalRatePerDay"];
        }
    }
    ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                         <p><b><?php echo '<img src="Images/CarImages/'.$car_image.'" style="max-width: 300px;">'; ?></b></p>
                    </div>
                    <h1 class="mt-5 mb-3"><?php echo $car_make . ' ' . $car_model; ?></h1>
                    <div class="form-group">
                        <label>Year</label>
                        <p><b><?php echo $car_year; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Color</label>
                        <p><b><?php echo $car_color; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Battery Capacity</label>
                        <p><b><?php echo $car_battery_capacity; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Range Per Charge</label>
                        <p><b><?php echo $car_range_per_charge; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Rental Rate Per Day</label>
                        <p><b><?php echo '$' . $car_rental_rate_per_day; ?></b></p>
                    </div>

                    <?php if (
                        isset($_SESSION["permissions"]) &&
                        $_SESSION["permissions"] === "super"
                        ) {
                        echo '<div> <a href="modify-car.php?id=' . htmlspecialchars($car_id) . '" class="btn btn-primary">Modify</a> </div>';
                    } ?>
                        <?php if (
                        isset($_SESSION["permissions"]) &&
                        $_SESSION["permissions"] === "visitor"
                        ) {
                        echo '<div> <a href="rent-car.php?id=' . htmlspecialchars($car_id) . '" class="btn btn-primary">Rent</a> </div>';
                    } ?>

                    <?php
                    // Function to check if the referer is carlist.php
                    function getBackUrl() {
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            $referer = $_SERVER['HTTP_REFERER'];
                    // Check if the referer contains 'carlist.php'
                            if (strpos($referer, 'car-list.php') !== false) {
                            return 'car-list.php';
                            }
                        }
                        return 'index.php';
                    }
    
                    $backUrl = getBackUrl();
                    ?>
                    <p><a href="<?php echo $backUrl; ?>" class="btn btn-primary">Back</a></p>

                </div>
            </div>
        </div>
    </div>

<?php
// Check existence of id parameter before processing
if (isset($_GET["id"])) {

    $car_id = $_GET["id"];
    $review_id = "";
    $user_id = "";
    $title = "";
    $body = "";
    $rating = "";
    $posted_by = "";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Establish connection with database
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set charset to utf-8
    $conn->set_charset("utf8");

    // Prepare the SQL statement with a parameter placeholder
    $review_sql = "SELECT reviews.*, users.first_name AS FirstName,
                    users.last_name AS LastInitial, 
                    users.profile_picture AS ProfilePicture
                    FROM reviews
                    JOIN cars ON reviews.CarID = cars.CarID
                    JOIN users ON reviews.UserID = users.user_id
                    WHERE reviews.CarID = ?
                    ORDER BY RAND()";

if ($stmt = $conn->prepare($review_sql)) {
    // Bind the car_id parameter to the SQL statement
    $stmt->bind_param("i", $car_id); // "i" denotes the type is integer
    $stmt->execute();

    // Get the result set from the prepared statement
    $reviews_result = $stmt->get_result();

    echo'<div class="reviews-header">
            <label> Reviews </label> 
        </div>';

    // Ensure the user is logged in before allowing them to write a review
    if (isset($_SESSION['user_id'])) {
        echo '<div> <a href="write-review.php?car_id=' . htmlspecialchars($car_id) . '" class="btn btn-primary" style="width: 40%; display: block; margin: 0 auto;">Write Review</a> </div>';
        echo '<hr style="border: none; border-top: 15px solid #00bcd4; width: 100%;">';
    } else {
        echo '<p style="text-align: center">You must <a href="login.php">log in</a> to write a review.</p> ';
        echo '<hr style="border: none; border-top: 15px solid #00bcd4; width: 100%;">';
    }

    // Start the HTML output
    echo '<div class="reviews-container">';

    // Check if there are any rows in the result set
    if ($reviews_result->num_rows > 0) {
    
    // Fetch each row of the result set
    while ($row = $reviews_result->fetch_assoc()) {
        echo '<div class="reviews-card">
                <div class="reviews-item">
                    <div class="review-profile-header">

                    <img src=" Images/ProfileImages/' . htmlspecialchars($row["ProfilePicture"]) . '" alt="' . htmlspecialchars($row["FirstName"]) .
                     '\'s Profile Picture" class="review-userpfp">
                    <p class="review-user">' . htmlspecialchars($row["FirstName"]) . ' ' .
                    htmlspecialchars(substr($row["LastInitial"], 0, 1)) .'</p>

                    <p class="review-rating">' . htmlspecialchars($row["Rating"]) . '/5</p>
                    <p class="review-postedby">Posted By: ' . htmlspecialchars($row["PostedBy"]) . '</p>
                
                    </div>

                    <p class="review-title">' . htmlspecialchars($row["Title"]) . '</p>
                    <p class="review-body">' . htmlspecialchars($row["Body"]) . '</p>
                </div>
              </div><br>';
    }
}
    else {
        // Echo that there aren't any reviews found.
        echo '</div>'; // Close the reviews-container div
        echo'<p style= "text-align: center; padding: 1em;"> No reviews found. </p>';
            
    
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle errors with preparing the statement
    echo "Error: " . $conn->error;
}
}
?>

</body>

</html>
