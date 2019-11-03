<?php
//navbar
$parameter = $_POST["license_number"];

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
        <div align=\"right\">
        <form action=\"cx_dir.php\" method=\"post\">
                <input type=\"hidden\" name=\"license_number\" value=\"" . $parameter .  "\">
                <input type=\"submit\" value=\"Customer Directory\" name=\"Submit\" />
            </form>
        </div>
    </header>
  </body>

    <h1 align=\"right\"> Agent # " . $parameter . "</h1>");

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

$sql = "SELECT license_number, mls_id, days_on_market, asking_price FROM listing NATURAL JOIN assigned_agent JOIN realtor USING(license_number) WHERE license_number = ?";

// prepare and bind
$stmt = $conn->prepare($sql);

$stmt->bind_param('i', $parameter);

$stmt->execute();

$stmt->bind_result($license_number ,$mls_id, $day_on_market, $asking_price);

// set parameters and execute
echo("<h2>All Your Listings</h2>
    <table>
    <tr><th>MLS ID</th> <th>Days on Market</th> <th>Asking Price</th><th>Viewings</th>
");
while($stmt->fetch()) {
    echo("
        <tr>
            <th><a href=\"listing_main_page.php?mls_id=" . $mls_id . "\">"
            . $mls_id . "</a></th>
            <th>" . $day_on_market . "</th>
            <th>" . $asking_price . "</th>
            <th> <form action=\"schedules.php\" method=\"post\">
            <input type=\"hidden\" name=\"mls_id\" value=\"" . $mls_id .  "\">
            <input type=\"submit\" value=\"See Viewings\" name=\"Submit\" />
        </form>
    ");
}
echo("
</table>
<p align=\"center\"> ~ end of results ~ </p>");

echo("<h2> Listings with an Offer! </h2>");
$sql2 = "SELECT mls_id, days_on_market, max(amount) FROM offers NATURAL JOIN listing NATURAL JOIN assigned_agent NATURAL JOIN realtor WHERE license_number=? GROUP BY mls_id";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('i',$parameter);
$stmt2->execute();
$stmt2->bind_result($mls_id,$day_on_market,$amount);

//set params and execute

echo("<table><tr><th>MLS ID</th><th>Days on Market</th><th>Highest Offer</th></tr>");

while($stmt2->fetch()) {
    echo("
        <tr><th>
            <a href=\"listing_main_page.php?mls_id=" . $mls_id . " \">"
                . $mls_id . "</a></th>
        <th>" . $day_on_market . "</th>
        <th>" . $amount . "</th>
    ");
}
echo("
</table>
<p align=\"center\"> ~ end of results ~ </p>");

/////////QUERY 3 /////////

echo("<h2> Your Brokerage </h2>");

$sql4 = "select name, street_number, street_name, city from brokerage a where brokerage_id in (select brokerage_id from realtor where license_number = ? )";


$stmt4 = $conn->prepare($sql4);

$stmt4->bind_param('i',$parameter);

$stmt4->execute();

$stmt4->bind_result($rname,$rnum,$rstreet,$rcity);
echo($rname);
while($stmt4-> fetch()){
echo('<p> Your Brokerage information is ' . $rname .' '. $rnum . ' '. $rstreet . ' '.  $rcity .  '</p>' );

}
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

$sql5 = ' select people_id, first_name, last_name, count(Sold)
FROM (people natural join realtor natural join assigned_agent) join listing using (mls_id)
Where sold = 1
Group by people_id
having Count(sold) > 0
order by count(sold) DESC';

$stmt5=$conn->prepare($sql5);

$stmt5->execute();

//$stmt->bind_result($mls, $sellID);
$stmt5->bind_result($pplID, $fname, $lname, $count);

// set parameters and execute
echo("
<h2> Top Sellers </h2>
<table>

<tr> <th> Name </th> <th> Listings Sold </th> </tr>
");
while($stmt5->fetch()) {
  echo(
  "<tr>
    <th>" .
      $fname .
    " " .
      $lname.
    "</th>
    <th> " .
      $count . "</th>");
}
echo ("
</table>
<p align=\"center\"> ~ SUCCESS ~ </p>");
?>
