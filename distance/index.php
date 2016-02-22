
<html>
    <head>
     <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
     
        <title></title>
        <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script>
   function start() {
         var address = (document.getElementById('start'));
        
        var autocomplete = new google.maps.places.Autocomplete(address);
        autocomplete.setTypes(['geocode']);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
        }
   
        document.getElementById('lat').innerHTML = place.geometry.location.lat();
        document.getElementById('long').innerHTML = place.geometry.location.lng();
        });
  }
   google.maps.event.addDomListener(window, 'load', start);
 
    function end() {
         var address = (document.getElementById('end'));
        var autocomplete = new google.maps.places.Autocomplete(address);
        autocomplete.setTypes(['geocode']);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }
        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
        }
   
        document.getElementById('lat').innerHTML = place.geometry.location.lat();
        document.getElementById('long').innerHTML = place.geometry.location.lng();
        });
  }
   google.maps.event.addDomListener(window, 'load', end);
    </script>
    </head>
    <?php
function pr($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
function getLntend($end_point) {
    if(!empty($end_point) ){
 {
     $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($end_point) . "&sensor=false";
    $result_string = file_get_contents($url);
    $result = json_decode($result_string, true);
    if (!isset($result['results'][0]) || empty($result['results'][0])) {
        return 0;
    } else {
        $result1[] = $result['results'][0];
        $result2[] = $result1[0]['geometry'];
        $result3[] = $result2[0]['location'];
        return $result3[0];
    }
}
}
}
function getLntstart($start_point) {
    if(!empty($start_point)) {
 {
     $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($start_point) . "&sensor=false";
    $result_string = file_get_contents($url);
    $result = json_decode($result_string, true);
    if (!isset($result['results'][0]) || empty($result['results'][0])) {
        return 0;
    } else {
        $result1[] = $result['results'][0];
        $result2[] = $result1[0]['geometry'];
        $result3[] = $result2[0]['location'];
        return $result3[0];
    }
}
}
}
if ( isset( $_POST['submit'])) {
   $start_point = $_POST['start_point'];
       $start_point_lat_long = getLntstart($start_point);
     $lat1 = ($start_point_lat_long['lat']);
     pr($lat1);
     $lng1 = ($start_point_lat_long['lng']);
       pr($lng1);
   $end_point = $_POST['end_point'];
   $end_point_lat_long = getLntend($end_point);
   $lat2  = ($end_point_lat_long['lat']);
     pr($lat2);
   $lng2  = ($end_point_lat_long['lng']);
     pr($lng2);
   $distance = getDistanceBetweenPoints($lat1, $lng1, $lat2, $lng2);
pr($distance);
 $dist = GetDrivingDistance($lat1, $lng1, $lat2, $lng2);
    echo 'Distance: <b>'.$dist['distance'].'</b><br>Travel time duration: <b>'.$dist['time'].'</b>';
}
function getDistanceBetweenPoints($lat1, $lng1, $lat2, $lng2) {
    $theta = $lng1 - $lng2;
    $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $kilometers = $miles * 1.609344;
    return $kilometers;
}
function GetDrivingDistance($lat1, $lng1, $lat2, $lng2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$lng1."&destinations=".$lat2.",".$lng2."&mode=driving&language=pl-PL";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return array('distance' => $dist, 'time' => $time);
}
?>
    <body>
        <h1 style="text-align: center;">calculate distance</h1>
        <form method="post">
        <div class="row">
        <div class="col-md-4 col-md-offset-2">
            enter start place<br>
            <input type="text" name="start_point" id="start">   
        </div>
        <div class="col-md-4 col-md-offset-2">
            enter end place<br>
         <input type="text" name="end_point" id="end">   
     </div>
            <br>
            <br>
            <br>
            <br>
        </div>
            <div class="col-md-4 col-md-offset-5">
                <button  name="submit" class="btn btn-info" >enter to know distance</button>
           </div>
            </form>
        <br>
        <br>
        <div class="col-md-6 col-md-offset-4">
                <?php if(!empty($distance)){ ?>
              <?php     
               echo 'Distance: <b>'.$dist['distance'].'</b><br>Travel time duration: <b>'.$dist['time'].'</b>';
                }
                ?>
        </div>
    </body>
</html>
