<?php
echo("<!DOCTYPE html>
<html lang=\"en\" dir=\"ltr\">
<head>
    <meta charset=\"utf-8\">
    <title>Listings</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\">
</head>
<body>
    <header class='header'>
    <h1 class='logo'><a href='index.html'>RESS</a></h1>
        <ul class='nav'>
            <li><a href='index.html'>Buyer</a></li>
            <li><a href='seller.html'>Seller</a></li>
            <li><a href='agent.html'>Agent</a></li>
        </ul>
    </header>
<body>
");

include ('./my_connect.php');

// Create connection
$conn = get_mysqli_conn();

// Check connection
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}

//$sql1 = 'select mls_id from listing';

//$sql = " select q.mls_id, q.asking_price, q.seller_id from listing q where lower(q.city) LIKE '?' and q.bedrooms >= ? and q.bathrooms >= ? and q.asking_price <= ? and q.square_feet >= ? " ;
$sql = " select mls_id, asking_price, seller_id
from listing where city LIKE CONCAT(?, \"%\")
and bedrooms >= ? and bathrooms >= ? and
asking_price <= ? and square_feet >= ?" ;

// prepare and bind
$stmt = $conn->prepare($sql);


$city = $_GET['City'];

if($city == ''){
  $city = '';
}

$bathrooms = $_GET['Number_of_Bathrooms'];

if($bathrooms == ''){
  $bathrooms = 0;
}

$bedrooms = $_GET['Number_of_Bedrooms'];
if($bedrooms == ''){
  $bedrooms = 0;
}

$price = $_GET['Max_Price'];
if($price == ''){
  $price = 999999999;
}

$square_feet = $_GET['Min_Square_Footage'];
if($square_feet == ''){
  $square_feet = 0;
}

//echo($parameter);
$stmt->bind_param('sssss',$city,$bedrooms,$bathrooms,$price,$square_feet);

$stmt->execute();

//$stmt->bind_result($mls, $sellID);
$stmt->bind_result($mls_id,$asking_price,$seller_id);

// set parameters and execute
while($stmt->fetch()) {
	echo("<p> <a href=\"listing_main_page.php?mls_id=" . $mls_id . "\">" . $mls_id . '</a>'.
  '<ul> <li> Price: ' . $asking_price . '</li> <li> Home Owner ID: ' . $seller_id . "</li> </ul> </p>");
}
//echo ("<p> end of results </p>");
echo '<p> End of Available Listings </p>';
 ?>
