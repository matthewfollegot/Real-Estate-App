<?php
//navbar details
$parameter = $_GET["seller_id"];

// mysqli connection via user-defined function
include ('./my_connect.php');

// Create connection
$conn = get_mysqli_conn();

// Check connection
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}echo("<p> connection works </p>");

$sql = 'select mls_id, city from listing where seller_id = ?';

echo("<p> SQL Equn assigned </p>");

// prepare and bind
$stmt = $conn->prepare($sql);
echo("<p> SQL prepared </p>");

echo($parameter);
$stmt->bind_param('s', $parameter);
echo("<p> SQL param binded </p>");

$stmt->execute();
echo("<p> SQL excecuted </p>");

//$stmt->bind_result($mls, $sellID);
$stmt->bind_result($mls);
echo("<p> SQL resulted binded </p>");

// set parameters and execute
while($stmt->fetch()) {
	echo($mls);
	//echo (" <p> MLS: " . $mls . " - Seller ID: " . $sellID .  "</p>");
}
echo ("<p> end of results </p>");

echo("<p> SQL printed </p>");
 ?>
