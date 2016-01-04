<?php
  $user_agent   = $_SERVER['HTTP_USER_AGENT'];
  $hostaddress  = $_SERVER['REMOTE_HOST'];
  $ipaddress    = $_SERVER['REMOTE_ADDR'];
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>Emblem</title>


<body>


<h3>Date:</h3>
<?php  print date('c'); ?><br>
<h3>UserAgent:</h3>
<?php  print $user_agent; ?><br>
<h3>Host:</h3>
<?php  print $hostaddress; ?><br>
<h3>IP</h3>
<?php  print $ipaddress; ?><br>
<br>
<h3>Location:</h3>
<p id="locate"></p>


<script>
var x = document.getElementById("locate");
window.onload = function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude +
    "<br>Longitude: " + position.coords.longitude + "<br>Accuracy: " + position.coords.accuracy + "m";
}
function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}
</script>
</body>
</html>
