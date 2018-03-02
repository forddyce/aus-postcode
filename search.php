<?php

$data = [];
if (isset($_GET['query'])) {
    $dbname = "db_name";
    $mysqli = new mysqli("localhost", "root", "password", $dbname);

    if ($mysqli->connect_errno) {
        echo "Connect failed: %s\n", mysqli_connect_error();
    }

    $query = strtoupper(trim($_GET['query']));

    $result = $mysqli->query("SELECT * FROM postcode_db WHERE suburb LIKE '%" . $query . "%' OR postcode LIKE '%" . $query . "%'");

    if ($result) {
        while ($row = $result->fetch_assoc()) {
          array_push($data, $row['suburb'] . '-' . $row['postcode']);
      }
      $result->free();
  }

  $mysqli->close();
}

echo json_encode($data);

?>
