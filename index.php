<!DOCTYPE html>
<html>
<head>
  <title>AUS Postcode</title>
</head>
<body>
  <h1>Australia Suburb Search</h1>
  <br>
  <form action="" method="get">
    <input type="text" placeholder="postcode" name="postcode" />
    <input type="number" placeholder="distance in km" name="radius" />
    <button type="submit">Search</button>
  </form>

  <?php
    if (isset($_GET['radius']) && isset($_GET['postcode'])) {
      $dbname = "db_name";
      $mysqli = new mysqli("localhost", "username", "password", $dbname);

      if (mysqli_connect_errno()) {
        echo "Connect failed: %s\n", mysqli_connect_error();
      }

      $radius = trim($_GET['radius']); // in km or $_POST['distance']

      // if (!is_numeric($radius)) return false;
      
      $postcode = trim($_GET['postcode']); // or other postcode

      // select the target
      if (!$result = $mysqli->query("SELECT * FROM postcode_db WHERE postcode = " . $postcode . " LIMIT 1")) {
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
        *,( 6371 * acos( cos( radians(" . $target['lat'] . ") ) * cos( radians( `lat` ) ) * cos( radians( `lon` ) - radians(" . $target['lon'] . ") ) + sin( radians(" . $target['lat'] . ") ) * sin( radians( `lat` ) ) ) ) AS distance
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
    }

  ?>
</body>
</html>