<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>
    <link rel="icon" href="images/logo1.png" type="image/x-icon">
    <title>List of Users</title>
    <style>
    body {
      background-color: #1c1c1c;
      color: #f5f5f5; /* Ensures text is readable against the dark background */
      font-family: Arial, sans-serif;
    }

    h1 {
      text-align: center;
      color: #00bcd4;
      margin-bottom: 20px;
    }

    /* General styles for the table container */
    .table-container {
      width: 90%;
      margin: 40px auto;
      background-color: #2c2c2c;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      overflow: auto; /* Ensure content does not overflow */
    }

    /* Styles for the DataTable */
    table.dataTable {
      width: 100%;
      border-collapse: collapse;
      background-color: #2c2c2c;
    }

    table.dataTable thead th {
      background-color: #00bcd4;
      color: white;
      padding: 10px;
      border-bottom: 2px solid #ddd;
      text-align: left;
    }

    table.dataTable tbody td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      color: #f5f5f5;
    }

    table.dataTable tbody tr:hover {
      background-color: #383838;
      cursor: pointer;
    }

    table.dataTable tbody tr td div {
      width: 100%;
      height: 100%;
      padding: 10px;
    }

    /* Styles for the search inputs */
    .dt-input {
      background-color: #4b4b4b;
      border: 1px solid #00bcd4;
      color: #f5f5f5;
      padding: 5px;
      margin-top: 5px;
      margin-bottom: 5px; /* Added margin-bottom for spacing */
      width: calc(100% - 12px); /* Adjust width to fit within the header */
      border-radius: 5px;
      font-size: 14px;
      box-sizing: border-box; /* Ensure padding and border are included in the element's total width and height */
    }

    /* Ensure the container of the inputs has enough padding */
    .dataTables_wrapper .dataTables_filter input {
      margin-bottom: 10px;
    }

    .dt-input::placeholder {
      color: #b0b0b0;
    }

    /* Styles for the admin buttons */
    #admin_buttons {
      background-color: #f44336;
      border: none;
      color: white;
      padding: 5px 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 14px;
      margin: 2px;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    #admin_buttons:hover {
      background-color: #d32f2f;
    }

    /* Additional styles for general buttons */
    .general-button {
      background-color: #00bcd4;
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 10px 2px;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .general-button:hover {
      background-color: #0097a7;
    }

    .resource-buttons {
      padding-left: 80px;
    }

    .dataTables_length {
      padding-bottom: 10px;
    }

    .dataTables_info {
      padding-top: 10px;
    }
    
    .dataTables_paginate {
      padding-top: 10px;
    }
  </style>
</head>
<body>
<?php
  include_once "header.php";
  require_once "connection.php";

  $loggedInUserEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : null;
  ?>

  <h1 style="text-align: center;">List of Users</h1>
  <?php
  if (
      isset($_SESSION["permissions"]) &&
      ($_SESSION["permissions"] === "super")
  ) {
      echo '<div class="resource-buttons">
            <a href="add-user.php">
              <button type="button" class="general-button">Add User</button>
            </a>

            <a href="delete-user.php">
              <button type="button" class="general-button">Delete User</button>
            </a>

            <a href="modify-user.php">
              <button type="button" class="general-button">Modify User</button>
            </a>
          </div>';
      if (isset($_SESSION["first_name"])) {
          echo "<h1> Hello " . $_SESSION["first_name"] . "! </h1>";
      }
  }
  ?>
  <div class="table-container">
    <table id="userTable" class="display" cellspacing="0">
      <thead>
        <tr>
          <th style="color: white;">User ID</th>
          <th style="color: white;">First Name</th>
          <th style="color: white;">Last Name</th>
          <th style="color: white;">Email</th>
          <th style="color: white;">Password</th>
          <th style="color: white;">Permissions</th>
          <th style="color: white;">Actions</th>

        </tr>
      </thead>
      <tbody>
        <?php
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><div onclick="window.location.href=\'view-user.php?id=' . $row["user_id"] . '\'">' . $row["user_id"] . '</div></td>';
                echo '<td><div onclick="window.location.href=\'view-user.php?id=' . $row["user_id"] . '\'">' . $row["first_name"] . '</div></td>';
                echo '<td><div onclick="window.location.href=\'view-user.php?id=' . $row["user_id"] . '\'">' . $row["last_name"] . '</div></td>';
                echo '<td><div onclick="window.location.href=\'view-user.php?id=' . $row["user_id"] . '\'">' . $row["email"] . '</div></td>';
                echo '<td><div onclick="window.location.href=\'view-user.php?id=' . $row["user_id"] . '\'">' . '*****' . '</div></td>';
                echo '<td><div onclick="window.location.href=\'view-user.php?id=' . $row["user_id"] . '\'">' . $row["permissions"] . '</div></td>';
                if (isset($_SESSION["permissions"]) && $_SESSION["permissions"] === "super") {
                  echo '<td><div class="resource-buttons">
                  <a href="modify-user.php?id=' . $row["user_id"] . '">
                  <button type="button" class="general-button">Modify</button>
                  </a>
                </div></td>';
              }
              echo '</tr>';
            }
        } else {
            echo "<tr><td colspan='7'>0 results</td></tr>"; // Adjust the colspan according to the remaining columns
        }
        $result->close();
        ?>
      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function () {
    var table = $('#userTable').DataTable({
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var header = $(column.header());

                var searchInput = $('<input type="text" class="form-control form-control-sm dt-input" placeholder="Search">')
                    .appendTo(header)
                    .on('keyup change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        }
    });
});
  </script>
</body>
</html>