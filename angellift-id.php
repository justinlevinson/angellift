<?php 

mysql_connect("localhost", "root", "root");
mysql_select_db("angellist");
$result = mysql_query("select * from id");

?>

<html>
<body>
<table border=1>

<?php
// Create a curl handle
$ch = curl_init();


while ($row = mysql_fetch_object($result)) {
	echo "<tr>";
	echo "<td>";
    echo $row->name;
    echo "</td><td>";


// Escape a string used as a GET parameter
$location = urlencode($row->name);


// Compose an URL with the escaped string
//$url = "http://example.com/add_location.php?location={$location}";
$url = "https://api.angel.co/1/search?query={$location}&type=Startup";
//echo $url;
// Result: http://example.com/add_location.php?location=Hofbr%C3%A4uhaus%20%2F%20M%C3%BCnchen

// Send HTTP request and close the handle
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curl_result = curl_exec($ch);
$curl_result = json_decode($curl_result);

echo "<table border=1>";
foreach($curl_result as $startup) {
	//echo "startup1";
	//var_dump($startup);
	echo "<tr>";
	echo "<td>";
	echo $startup->name;
	echo "</td><td>";
	echo $startup->id;
	echo "</td><td>";
	echo "<a href=\"";
	echo $startup->url;
	echo "\">".$startup->name."</a>";

	echo "</td></tr>";

}
	echo "</table>";
    echo "</td>";
    echo "</tr>";
}
curl_close($ch);

 ?>
  