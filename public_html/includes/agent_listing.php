<?php
//navbar
$parameter = $_POST["license_number"];

echo("<!DOCTYPE html>
<html lang=\"en\" dir=\"ltr\">
  <head>
    <meta charset=\"utf-8\">
    <title>Agent Home Page</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\">
  </head>
  <body>
    <header>
	     <div class=\"nav\">
    		<span><a href=\"index.html\">Buyer</a></span>
    		<span><a href=\"seller.html\">Seller</a></span>
    		<span><a href=\"agent.html\">Agent</a></span>
    	</div>
    </header>
    <body>

    <h1> Your License Number: " . $parameter . "</h1>");

// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function
include ('./my_connect.php');
get_mysqli_conn();

// Create connection
$conn = get_mysqli_conn();

// Check connection
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}

$sql = 'SELECT license_number, mls_id FROM assigned_agent join realtor using(license_number) WHERE license_number = ?';

// prepare and bind
$stmt = $conn->prepare($sql);

$stmt->bind_param('i', $parameter);

$stmt->execute();

$stmt->bind_result($license_number ,$mls_id);

// set parameters and execute
while($stmt->fetch()) {
	echo (" <p>  your license number is " . $license_number . " and your listing(s) are " . $mls_id .  "</p>");
}
?>