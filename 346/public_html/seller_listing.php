<?php
//navbar details
$parameter = $_POST["seller_id"];

echo("<!DOCTYPE html>
<html lang=\"en\" dir=\"ltr\">
  <head>
    <meta charset=\"utf-8\">
    <title>Seller's Listings</title>
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
  </body>

    <h1 align=\"right\"> Seller # " . $parameter . "</h1>");

// mysqli connection via user-defined function
include ('./my_connect.php');

// Create connection
$conn = get_mysqli_conn();

// Check connection
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}

//////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////

$sql = 'select mls_id, street_number, street_name, asking_price from listing where seller_id = ?';

$stmt = $conn->prepare($sql);

$stmt->bind_param('s', $parameter);

$stmt->execute();

$stmt->bind_result($mls, $num, $name, $price);

echo("<h2> All Your Listings </h2>
<table>
<tr> <th> MLS ID </th> <th> Address </th> <th> Asking Price</th>  </tr>
");
while($stmt->fetch()) {
	echo(
  "<tr>
    <th> <a href=\"listing_main_page.php?mls_id=" . $mls . "\">" .
      $mls .
    "</a></th>
    <th>" .
      $num . " " . $name.
    "</th>
    <th> " .
      $price ."</th>");
}
echo ("
</table>
<p align=\"center\"> ~ end of results ~ </p>");

$stmt->close();
$conn-> close();

 ////////////////////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////

echo("<h2> Listings with an Offer! </h2>");

 $query2 = get_mysqli_conn();
 $sql2 = 'select mls_id, asking_price, amount from listing natural join offers where seller_id = ? ORDER BY mls_id DESC';

 $stmt2 = $query2->prepare($sql2);

 $stmt2->bind_param('s', $parameter);

 $stmt2->execute();

 //$stmt->bind_result($mls, $sellID);
 $stmt2->bind_result($mlsID, $ask, $num);

 // set parameters and execute
 echo("
 <table>
 <tr> <th> MLS ID </th> <th> Asking Price </th> <th> Offer </th>  </tr>
 ");
 while($stmt2->fetch()) {
 	echo(
   "<tr>
     <th> <a href=\"listing_main_page.php?mls_id=" . $mlsID . "\">" .
       $mlsID .
     "</a> </th>
     <th>" .
       $ask.
     "</th>
     <th> " .
       $num . "</th>");
 }
 echo ("
 </table>
 <p align=\"center\"> ~ end of results ~ </p>");

$query2->close();
$stmt2->close();

 ?>
