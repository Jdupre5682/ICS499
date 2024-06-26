<?php
session_start();
?>
<link rel="icon" href="/images/npo-favicon.png" type="image/x-icon">
<header data-role="Header" class="home-header">
  <a href="index.php"><img alt="image" src="./images/logo.jpg" loading="eager" class="home-image" /></a>
  <a href="index.php" rel="noreferrer noopener" class="home-link">
    CAR Grid View
  </a>
  <a href="npo-list.php" rel="noreferrer noopener" class="home-link1">
    <span class="home-text">Car Rental List View</span>
    <br />
  </a>
  <a href="help.php" rel="noreferrer noopener" class="home-link1">
    <span class="home-text">Help</span>
    <br />
  </a>

  

  <?php
  if (!isset($_SESSION['permissions'])) {
    echo '
    <a href="login.php">
    <button type="button" class="home-button button" class="login-button">Login</button></a>
    ';
  }

  if (isset($_SESSION['permissions'])) {
    if ($_SESSION['permissions'] == 'super') {
      echo '<a href="user-list.php" class="home-link">Users</a>';
      
    }
  }

  if (isset($_SESSION['permissions'])) {
    echo '
    <a href="logout.php">
    <button type="button" class="home-button button" class="login-button">Log out</button></a>
    ';
  }
  ?>

</header>