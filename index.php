<?php
// Now requires Client-ID to pull API request. Figured while updating, I may as well mash the script into 1 PHP.

// Don't know what Client ID is? https://blog.twitch.tv/client-id-required-for-kraken-api-calls-afbb8e95f843#.rtj2wf5wv

$clientID = "PUT YOUR CLIENT ID HERE";



$form = "<html>
<head>
<title>Twitch Status.</title>
</head>
<body>
Enter the username of the streamer you want to check the status of!
<br> <form action='?' method='post'> <p>Username: <input type='text' name='stream' /></p> <p><input type='submit' /></p> </form>
</body>
</html>";

if(!isset($_POST['stream'])) {
	die($form);
} else {

$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
              "User-Agent: Twitch-Status Kraken API\r\n". // i.e. An iPad 
              "Client-ID: ". $clientID ."\r\n"
  )
);
$context = stream_context_create($options);

$json = json_decode(file_get_contents("http://api.twitch.tv/kraken/channels/". $_POST['stream']. "?on_site=1", false, $context));


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
$delay = "";
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

}
?>

