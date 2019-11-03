<?php
$parameter = $_POST["license_number"];

echo("<!DOCTYPE html>
<html lang=\"en\" dir=\"ltr\">
  <head>
    <meta charset=\"utf-8\">
    <title>Customer Directory</title>
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

/*
Agent listing should have:
<form action=\"cx_dir.php\" method=\"post\">
        <input type=\"hidden\" name=\"license_number\" value=\"" . $parameter .  "\">
        <input type=\"submit\" value=\"Customer Directory\"/>
    </form>
*/
// mysqli connection via user-defined function
include ('./my_connect.php');

// Create connection
$conn = get_mysqli_conn();

// Check connection
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}

$sql = 'SELECT first_name, last_name, phone_number, email
FROM people
WHERE people_id IN (SELECT people_id
					FROM seller_agent NATURAL JOIN seller
					WHERE license_number = ?)';

// prepare and bind
$stmt = $conn->prepare($sql);

$stmt->bind_param('i', $parameter);

$stmt->execute();

$stmt->bind_result($fname ,$lname, $phone_num, $email);

echo("
<h2 id=\"1\"> Contact of Listing Sellers </h1>
<table id=\"1\">
<tr> <th> Name </th> <th> Phone </th> <th> Email </th>  </tr>");

// set parameters and execute
while($stmt->fetch()) {
  echo(
   "<tr>
     <th>" .
       $fname . " " . $lname .
     "</th>
     <th>" .
       $phone_num.
     "</th>
     <th> " .
       $email . "</th>");
}
echo ("</table>");
$stmt-> close();

////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////

$sql = 'select first_name, last_name, phone_number, email
From people
Where people_id IN (SELECT people_id
					FROM buyers_agent NATURAL JOIN buyer
					Where license_number = ?)';

// prepare and bind
$stmt2 = $conn->prepare($sql);

$stmt2->bind_param('i', $parameter);

$stmt2->execute();

$stmt2->bind_result($fname ,$lname, $phone_num, $email);

echo("
<h2 id='1'> Contact of Current Buyers </h1>
<table id='1'>
<tr> <th> Name </th> <th> Phone </th> <th> Email </th>  </tr>");

// set parameters and execute
while($stmt2->fetch()) {
  echo(
   "<tr>
     <th>" .
       $fname . " " . $lname .
     "</th>
     <th>" .
       $phone_num.
     "</th>
     <th> " .
       $email . "</th>");
}
echo ("</table>");
$stmt2-> close();
