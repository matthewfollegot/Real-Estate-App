<?php
//navbar details
$parameter = $_GET["mls_id"];

echo("<!DOCTYPE html>
<html lang=\"en\" dir=\"ltr\">
  <head>
    <meta charset=\"utf-8\">
    <title>Available Listings</title>
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
</html>");

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

$sql = 'select mls_id,sell_or_rent,asking_price,square_feet,street_number,street_name,unit_number,city,province,postal_code,bedrooms,bathrooms,year_built,days_on_market,central_HVAC,seller_id,Sold,central_vaccum,property_tax from listing NATURAL JOIN house Where mls_id = ?';

$stmt = $conn->prepare($sql);

$stmt->bind_param('s', $parameter);

$stmt->execute();

$stmt->bind_result($mls_id,$sell_or_rent,$asking_price,$square_feet,$street_number,$street_name,$unit_number,$city,$province,$postal_code,$bedrooms,$bathrooms,$year_built,$days_on_market,$central_HVAC,$seller_id,$Sold,$central_vaccum,$property_tax);

while($stmt->fetch()) {
  echo("<h1> " . " " . $street_number. " " . $street_name. " " . $city . " ". $province. " " . $postal_code. " " . "</h1>");
  echo("<h2> Listing ID: " .$mls_id );
  if ($Sold == 1){
    echo("<h1 size=\"30\" color=\"red\">  PROPERTY SOLD! </h1> ");
  }echo(" <h2> Price " .$asking_price. "</h2>");
  echo(" <p> " . " The property status: " .$sell_or_rent.
       "<br> Total Area:" .$square_feet . "Sq Ft"
       ." <br>  Number of Beedrooms: " .$bedrooms
       ."<br> Number of Bathrooms: " .$bathrooms
       ."<br> Year Built: " .$year_built
       ."<br> Days on Market: " .$days_on_market
       ." <br> Central HVAC: " .$central_HVAC
       ." <br> Central Vaccum: " .$central_vaccum
       . "<br> Property Tax: $" . $property_tax  . "</p>");
}

$stmt->close();
$conn-> close();

////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

$query = get_mysqli_conn();

// Check connection
if ($query->connect_error) {
    exit("Connection failed: " . $query->connect_error);
}
$apartment = $query->prepare('select Amenity,mls_id, floor_number,maintenance_fee, in_unit_laundry,sell_or_rent,
asking_price,square_feet,street_number,street_name,unit_number,city,province,postal_code,bedrooms,
bathrooms,year_built,days_on_market,central_HVAC,seller_id,Sold
from listing natural join apartment natural join amenities where mls_id = ?');

$apartment->bind_param('s', $parameter);

$apartment->execute();

$apartment->bind_result($Amenity,$mls_id,$floor_number,$maintenance_fee,$in_unit_laundry,$sell_or_rent,$asking_price,$square_feet,$street_number,$street_name,$unit_number,$city,$province,$postal_code,$bedrooms,$bathrooms,$year_built,$days_on_market,$central_HVAC,$seller_id,$Sold);

while($apartment->fetch()) {
  echo("<h1> " . " " . $street_number. " " . $street_name. " " . $city . " ". $province. " " . $postal_code. " " . "Floor Number: " . $floor_number .  "</h1>");
  echo("<h2> Listing ID: " .$mls_id );
  if ($Sold == 1){
    echo("<h1 size=\"30\" color=\"red\">  PROPERTY SOLD! </h1> ");
  }echo(" <h2> Price " .$asking_price. "</h2>");
  echo(" <p> " . " The property status: " .$sell_or_rent
        ."<br> Total Area:" .$square_feet . "Sq Ft"
       ." <br>  Number of Beedrooms: " .$bedrooms
       ."<br> Number of Bathrooms: " .$bathrooms
       ."<br> Year Built: " .$year_built
       ."<br> Days on Market: " .$days_on_market
       ." <br> Central HVAC: " .$central_HVAC
       ."<br> In-House Laundry: " . $in_unit_laundry
       ."<br> Maintainence Fees: " . $maintenance_fee
       ."<br> Extra Amenities: " . $Amenity
       .  "</p>");
}

$apartment->close();
 ?>
