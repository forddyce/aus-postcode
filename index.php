<?php
  $mysqli = new mysqli("localhost", "root", "password", "taiwan_db");

  if (mysqli_connect_errno()) {
    echo "Connect failed: %s\n", mysqli_connect_error();
  }

  $radius = 40; // in km or $_POST['distance']

  // if (!is_numeric($radius)) return false;
  
  $postcode = 200; // or other postcode

  // select the target
  if (!$result = $mysqli->query("SELECT * FROM postcode_db WHERE postcode = " . trim($postcode) . " LIMIT 1")) {
    echo "Target not found.";
    return false;
  } else {
    while ($row = $result->fetch_assoc()) {
      $target = $row;
    }
    $result->free();
  }
  
  // get the results from target radius
  $results = $mysqli->query("SELECT
    *,
    ( 6371 * acos( cos( radians(" . $target['lat'] . ") ) * cos( radians( `lat` ) ) * cos( radians( `lon` ) - radians(" . $target['lon'] . ") ) + sin( radians(" . $target['lat'] . ") ) * sin( radians( `lat` ) ) ) ) AS distance
    FROM `postcode_db`
    HAVING distance <= " . $radius . "
    ORDER BY distance ASC");

  if (!$results) {
    echo "No suburb found near " . $target->suburb . " within " . $radius . "km";
    return false;
  }

  $html = "";

  while ($row = $results->fetch_assoc()) {
    $html .= "Post Code: " . $row['postcode'] . ", Suburb: " . $row['suburb'] . "<br>"; 
  }

  echo $html;

  $results->free();
  $mysqli->close();

?>