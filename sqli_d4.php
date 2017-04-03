<?php require("phpsqlajax_dbinfo.php");

//Set the content type to be XML, so that the browser will recognise it as XML.
//header( "content-type: application/xml; charset=ISO-8859-15" );
// This version uses PHP's DOM functions to output XML...
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Connect to db..
$mysqli = new mysqli('localhost',$username ,$password, $database);

//Oh no! A connect_errno exists so the connection attempt failed!
if ($mysqli->connect_errno) {
// The connection failed. What do you want to do?
// You could contact yourself (email?), log the error, show a nice page, etc.
// You do not want to reveal sensitive information

//Let's try this:
echo "Sorry, this website is experiencing problems.";

//Something you should not do on a public site, but this example will show you
//anyways, is print out MySQL error related information -- you might log this
//echo "Error: Failed to make a MySQL connection, here is why:\n";
//echo "Errno: ". $mysqli->connect_errno . "\n";
//echo "Error: ". $mysqli->connect_error . "\n";

//You might want to show them something nice, but we will simply exit
exit;
}

// Select all the rows in the markers table
$query = "SELECT * FROM markers WHERE 1";
$result = $mysqli->query($query);
if (!$result) {
 die('Invalid query: ' . $mysqli->error());
}

header("Content-type: text/xml");
header('Cache-control: no-cache, must_revalidate');

while ($row = $result->fetch_assoc()){
// Add to XML document node
$node = $dom->createElement('marker');
$newnode = $parnode->appendChild($node);
$newnode->setAttribute("name",$row['name']);
$newnode->setAttribute("address", $row['address']);
$newnode->setAttribute("lat", $row['lat']);
$newnode->setAttribute("lng", $row['lng']);
$newnode->setAttribute("type", $row['type']);
}



echo $dom->save("coordinates.xml");

//echo '</xml>';
$mysqli->close();
?>