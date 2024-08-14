<?php
// Check if session is not started, start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="icon" href="images/logo1.png" type="image/x-icon">
<header data-role="Header" class="home-header">
<a href="index.php"><img alt="image" src="./images/logo1.png" loading="eager" class="home-image" /></a>

  <?php if (!isset($_SESSION["permissions"])) {
    echo '
    <a href="car-list.php" rel="noreferrer noopener" class="home-link1">
    <span class="home-text">Car Rental List View</span>
    <br />
  </a>
    ';
          echo '
          <a href="help.php" rel="noreferrer noopener" class="home-link1">
          <span class="home-text">Help</span>
          <br />
          </a>
        ';
      echo '
  <a href="login.php">
    <button type="button" class="home-button button login-button">Login</button>
  </a>
  ';

  } elseif (isset($_SESSION["permissions"])) {
      if (
          $_SESSION["permissions"] == "super"
      ) {
        echo '
        <a href="car-list.php" rel="noreferrer noopener" class="home-link1">
        <span class="home-text">Inventory</span>
        <br />
      </a>
        ';
        echo '
        <a href="user-list.php" rel="noreferrer noopener" class="home-link1">
          <span class="home-text">User List</span>
          <br />
        </a>
        ';
        echo '
        <a href="bookings.php" rel="noreferrer noopener" class="home-link1">
          <span class="home-text">Bookings</span>
          <br />
        </a>
        ';
        echo '
          <a href="help.php" rel="noreferrer noopener" class="home-link1">
          <span class="home-text">Help</span>
          <br />
          </a>
        ';
        echo '
        <a href="profile.php" rel="noreferrer noopener" class="home-link1">
        <span class="home-text">My Profile</span>
        <br />
        </a>
        ';
        echo '
        <a href="logout.php">
          <button type="button" class="home-button button login-button">ADMIN LOGOUT</button>
        </a>
        ';
      } elseif ($_SESSION["permissions"] == "visitor") {
        echo '
        <a href="car-list.php" rel="noreferrer noopener" class="home-link1">
        <span class="home-text">Car Rental List View</span>
        <br />
      </a>
        ';
        echo '
          <a href="help.php" rel="noreferrer noopener" class="home-link1">
          <span class="home-text">Help</span>
          <br />
          </a>
        ';
        echo '
          <a href="profile.php" rel="noreferrer noopener" class="home-link1">
          <span class="home-text">My Profile</span>
          <br />
          </a>
        ';
          echo '
    <a href="logout.php">
      <button type="button" class="home-button button login-button">USER LOGOUT</button>
    </a>
    ';
      }
  } ?>

</header>

<style type="text/css">
.home-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: #1c1c1c; /* Matches the main background */
    border-bottom: 2px solid #00bcd4; /* Adds a bottom border for separation */
    font-family: Arial, sans-serif;
    color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

/* Style for the links */
.home-link, .home-link1 {
    text-decoration: none;
    color: #00bcd4;
    font-size: 16px;
    margin-right: 20px;
    transition: color 0.3s ease;
}

.home-link:hover, .home-link1:hover {
    color: #ffffff; /* Changes color on hover for better visibility */
}

.home-text {
    display: inline;
    vertical-align: middle;
}

/* Style for the buttons */
.home-button {
    padding: 10px 20px;
    font-size: 14px;
    font-weight: bold;
    color: #ffffff;
    background-color: #00bcd4;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease; /* Added transition for smooth effect */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.home-button:hover {
    background-color: #0097a7; /* Darker shade on hover */
    transform: translateY(-2px); /* Slight lift on hover */
}

.button {
    margin-left: auto; /* Ensures the button stays at the rightmost position */
}

/* Additional styles for better aesthetics */
.home-header a {
    text-transform: uppercase; /* Makes the links uppercase for a cleaner look */
    letter-spacing: 0.05em; /* Adds slight spacing between letters */
}

.home-header .home-link1 {
    margin-left: 20px;
}

.home-header .home-button {
    margin-left: 20px;
}

.home-image {
    width: 150px;
    height: 150px;
    margin: var(--dl-space-space-unit);
    align-self: flex-start;
    object-fit: contain;
  }



</style>