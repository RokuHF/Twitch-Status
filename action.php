
<?php

# Grabs API results and decodes to managable format
$json = json_decode(file_get_contents("http://api.twitch.tv/kraken/channels/". $_POST['stream']. "?on_site=1"));


# Sets variable "partnered" to true if streamer is partnered
$partnered = "";
if ($json->partner == 1) {
	$partnered = "True";
} else {
	$partnered = "False";
}

# Sets variable "mature" to true if stream is flagged as being for 18+
$mature = "";
if ($json->mature == 1) {
	$mature = "True";
} else {
	$mature = "False";
}

# Sets variable "delay" to true if stream has reduced delay enabled
$mature = "";
if ($json->delay == 1) {
	$delay = "True";
} else {
	$delay = "False";
}

#Checks if logo exists. If it does, put it on the page.
if ($json->logo == "") { 
	
} else {
	echo "<img src=" . $json->logo . " height=150 width=150></img> <br>";
}

# Echoes out API results in readable format
echo "Stream Username: " . $json->display_name . "<br>";
echo "Stream Link: <a href=" . $json->url . ">" . $json->url . "</a><br>";
echo "Stream User ID: " . $json->_id . "<br>";
echo "Stream Title: " . htmlspecialchars($json->status) . "<br>";
echo "Partnered: " . $partnered . "<br>";
echo "Mature Content: " . $mature . "<br>";
echo "Delay Reduced: " . $delay . "<br>";
echo "Account Created: " . $json->created_at . "<br>";
echo "Last Active: " . $json->updated_at . "<br>";


?>
