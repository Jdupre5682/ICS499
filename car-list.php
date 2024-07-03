<!DOCTYPE html>
<html lang="en" style="background-color: #1c1c1c">
<head>
<link rel="icon" href="/images/favicon.png" type="image/x-icon">
  <meta charset="utf-8">
  <link href="./styles.css" rel="stylesheet" type="text/css" media="all" />
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/81c2c05f29.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
  <title>List of Available Cars</title>

  <style>
    .table-container {
      width: 100%;
      overflow-x: auto;
    }

    .table-container th, .table-container td {
      padding: 8px;
      text-align: center;
    }

    #carTable_wrapper {
      overflow-x: hidden;
    }

    #carTable {
      width: 100%;
      table-layout: fixed;
    }

    #carTable td {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 200px;
    }
  </style>
</head>

<body>
  <?php
  include_once "header.php";
  require_once "connection.php";

  $loggedInUserEmail = isset($_SESSION['email']) ? $_SESSION['email'] : null;
  ?>

  <h1 style="text-align: center;">List of Available Cars</h1>
  <?php
  if (isset($_SESSION['permissions']) && ($_SESSION['permissions'] === 'admin' || $_SESSION['permissions'] === 'super')) {
    echo '<div class="resource-buttons">
            <a href="add-car.php">
              <button type="button" class="general-button">Add Car</button>
            </a>
          </div>';
    if (isset($_SESSION["first_name"])) {
      echo '<h1> Hello ' . $_SESSION["first_name"] . '! </h1>';
    }
  }
  ?>
  <div class="table-container">
    <table id="carTable" class="display" cellspacing="0">
      <thead>
        <tr>
          <th style="color: white;">CarID</th>
          <th style="color: white;">Make</th>
          <th style="color: white;">Model</th>
          <th style="color: white;">Year</th>
          <th style="color: white;">Color</th>
          <th style="color: white;">Battery Capacity</th>
          <th style="color: white;">Range Per Charge</th>
          <th style="color: white;">Rental Rate Per Day</th>
          <?php if (isset($_SESSION['permissions']) && $_SESSION['permissions'] == 'super') {
            echo '<th style="color: white;">Manager</th>';
          } ?>
          <th style="color: white;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        $sql = "SELECT * FROM cars";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td><div onclick="window.location.href=\'view-car.php?id=' . $row["CarID"] . '\';">' . $row["CarID"] . '</div></td>
                    <td><div onclick="window.location.href=\'view-car.php?id=' . $row["CarID"] . '\';">' . $row["Make"] . '</div></td>
                    <td><div onclick="window.location.href=\'view-car.php?id=' . $row["CarID"] . '\';">' . $row["Model"] . '</div></td>
                    <td><div onclick="window.location.href=\'view-car.php?id=' . $row["CarID"] . '\';">' . $row["Year"] . '</div></td>
                    <td><div onclick="window.location.href=\'view-car.php?id=' . $row["CarID"] . '\';">' . $row["Color"] . '</div></td>
                    <td><div onclick="window.location.href=\'view-car.php?id=' . $row["CarID"] . '\';">' . $row["BatteryCapacity"] . '</div></td>
                    <td><div onclick="window.location.href=\'view-car.php?id=' . $row["CarID"] . '\';">' . $row["RangePerCharge"] . '</div></td>
                    <td><div onclick="window.location.href=\'view-car.php?id=' . $row["CarID"] . '\';">' . $row["RentalRatePerDay"] . '</div></td>';
            if (isset($_SESSION['permissions']) && $_SESSION['permissions'] == 'super') {
              echo '<td><div onclick="window.location.href=\'view-car.php?id=' . $row["CarID"] . '\';">' . $row["Manager"] . '</div></td>';
            }
            echo '<td>';
            if (isset($_SESSION['permissions']) && $_SESSION['permissions'] == 'super') {
              echo '<form action="delete-query.php" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                      <input type="hidden" name="CarID" value="' . $row["CarID"] . '">
                      <input type="submit" id="admin_buttons" name="delete" value="Delete" />
                    </form>
                    <form action="modify-car.php?id=' . $row["CarID"] . '" method="POST">
                      <input type="hidden" name="CarID" value="' . $row["CarID"] . '">
                      <input type="submit" id="admin_buttons" name="update" value="Modify" />
                    </form>';
            }
            if (isset($_SESSION['permissions']) && $_SESSION['permissions'] == 'admin' && $loggedInUserEmail == $row['Manager']) {
              echo '<form action="delete-query.php" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                      <input type="hidden" name="CarID" value="' . $row["CarID"] . '">
                      <input type="submit" id="admin_buttons" name="delete" value="Delete" />
                    </form>
                    <form action="modify-car.php?id=' . $row["CarID"] . '" method="POST">
                      <input type="hidden" name="CarID" value="' . $row["CarID"] . '">
                      <input type="submit" id="admin_buttons" name="update" value="Modify" />
                    </form>';
            }
            echo '</td></tr>';
          }
        } else {
          echo "<tr><td colspan='9'>0 results</td></tr>"; // Adjust the colspan according to the remaining columns
        }
        $result->close();
        ?>
      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function () {
      var table = $('#carTable').DataTable({
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
