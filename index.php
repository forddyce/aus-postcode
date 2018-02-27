<?php
  function checkDistance(
    $lat1, $lon1, $lat2, $lon2, $unit
  ) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="jquery-ui.css">
  <title>AUS Postcode</title>
</head>
<body>
  <div style="float:left; width:45%; margin-right: 15px;">
    <h1>Australia Suburb Search</h1>
    <br>
    <form action="" method="get">
      <input type="text" placeholder="Search Query" name="query" value="<?php isset($query) ? $query : '' ?>" required="" />
      <input type="number" placeholder="distance in km" name="radius" value="<?php isset($radius) ? $radius : '' ?>" required="" />
      <button type="submit">Search</button>
    </form>

    <?php
      if (isset($_GET['radius']) && isset($_GET['query'])) {
        $dbname = "db_name";
        $mysqli = new mysqli("localhost", "root", "password", $dbname);

        if ($mysqli->connect_errno) {
          echo "Connect failed: %s\n", mysqli_connect_error();
        }

        $radius = trim($_GET['radius']); // in km
        if (!is_numeric($radius)) {
          echo "Radius not numeric";
          return false;
        }
    
        // if query format is in SUBURB-POSTCODE      
        $query = explode('-', trim($_GET['query']));

        if (!isset($query[1])) {
          $query = trim($_GET['query']);
        } else {
          $query = $query[1];
        }

        // select the target
        $result = $mysqli->query("SELECT * FROM postcode_db WHERE postcode = " . $query . " LIMIT 1");

        $target = null;

        if (!$result) {
          echo "Target not found.";
        } else {
          while ($row = $result->fetch_assoc()) {
            $target = $row;
          }
          $result->free();
        }
        
        $markers = [];
        if (!is_null($target)) {
          // get the results from target radius
          $results = $mysqli->query("SELECT
            *,( 6371 * acos( cos( radians(" . $target['lat'] . ") ) * cos( radians( `lat` ) ) * cos( radians( `lon` ) - radians(" . $target['lon'] . ") ) + sin( radians(" . $target['lat'] . ") ) * sin( radians( `lat` ) ) ) ) AS distance
            FROM `postcode_db`
            HAVING distance <= " . $radius . "
            ORDER BY distance ASC");

          if (!$results) {
            echo "No suburb found near " . $target['suburb'] . " within " . $radius . "km";
          } else {
            $html = "<ul>";
            $loop = 1;
            while ($row = $results->fetch_assoc()) {
              $html .= "<li>Post Code: <strong>" . $row['postcode'] . "</strong>, Suburb: <strong>" . $row['suburb'] . "</strong>. Distance: <strong>" . checkDistance($target['lat'], $target['lon'], $row['lat'], $row['lon'], "K") . " km</strong></li>";

              array_push($markers, [$row['suburb'], $row['lat'], $row['lon'], $loop]);
              $loop++;
            }

            $html .= "</ul>";

            echo $html;
            $results->free();
          }
        }
        $mysqli->close();
      }
    ?>
  </div>

  <div style="float:right; width:50%;">
    <div id="map" style="height:500px; width:100%;"></div>
  </div>

  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="jquery.ui.js"></script>
  <script type="text/javascript">
    $('input[name="query"]').autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "search.php",
          data: {
            query: request.term
          },
          success: function(data) {
            response(JSON.parse(data));
          }
        })
      },
      minLength: 2
    });
  </script>

  <!-- Google Map stuff -->
  <?php if (isset($_GET['radius']) && isset($_GET['query'])) { ?>
    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCmgUALv3xWdyPrI69hX1b_eR_OJt8ieAY" type="text/javascript"></script>
    <script type="text/javascript">
      var locations = <?php echo json_encode($markers); ?>;

      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: new google.maps.LatLng(<?php echo $target['lat']; ?>, <?php echo $target['lon']; ?>),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var infowindow = new google.maps.InfoWindow();

      var marker, i;

      for (i = 0; i < locations.length; i++) { 
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }
    </script>
  <?php } ?>
  <!-- End Google Map -->
</body>
</html>