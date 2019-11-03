<?php
//navbar
//$parameter = $_POST["license_number"];

echo("works");

/*echo("<!DOCTYPE html>
<html lang=\"en\" dir=\"ltr\">
  <head>
    <meta charset=\"utf-8\">
    <title>Customer Directory</title>
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
");
*/
/*
//echo($parameter);

// mysqli connection via user-defined function
include ('./my_connect.php');

// Create connection
$conn = get_mysqli_conn();

// Check connection
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}

$sql = 'select first_name, last_name, phone_number, email
From people
Where people_id IN (SELECT people_id
					FROM seller_agent NATURAL JOIN seller
					Where license_number = ?)';

// prepare and bind
$stmt = $conn->prepare($sql);

$stmt->bind_param('i', $parameter);

$stmt->execute();

$stmt->bind_result($fname ,$lname, $phone_num, $email);

echo("<table>
<tr> <th> Name </th> <th> Phone </th> <th> Email </th>  </tr>
");
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
*/
?>
