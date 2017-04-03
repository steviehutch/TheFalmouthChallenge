<?php
require("phpsqlajax_dbinfo.php");

// Gets data from URL parameters.
$name = $_GET['name'];
$address = $_GET['address'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$type = $_GET['type'];

// Open a connection to a MySql server..
$mysqli = new mysqli('localhost',$username ,$password, $database);
//Oh no! A connect_errno exists so the connection attempt failed!
if ($mysqli->connect_errno) {
// The connection failed. What do you want to do?
// You could contact yourself
// You do not want to reveal sensitive information
//Let's try this:
echo "Sorry, this website is experiencing problems.";
echo "Error: Failed to make a MySQL connection, here is why:\n";
echo "Errno: ". $mysqli->connect_errno . "\n";
echo "Error: ". $mysqli->connect_error . "\n";
exit;
}

// Inserts new row with place data.
$query = sprintf("INSERT INTO markers " .
" (id, name, address, lat, lng, type ) " .
" VALUES (NULL, '%s', '%s', '%s', '%s', '%s');",
$mysqli->real_escape_string($name),
$mysqli->real_escape_string($address),
$mysqli->real_escape_string($lat),
$mysqli->real_escape_string($lng),
$mysqli->real_escape_string($type));
$result = $mysqli->query($query);

$mysqli->close();

if (!$result) {
 die('Invalid query: ' . mysql_error());
}

?>