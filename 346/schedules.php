<?php
$parameter = $_POST["mls_id"];

echo("<!DOCTYPE html>
<html lang=\"en\" dir=\"ltr\">
  <head>
    <meta charset=\"utf-8\">
    <title>Viewings Page</title>
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
</html>
");

//////////////////////////////
//////////////////////////////

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
echo("<h2 class='font'>Scheduled Viewings</h2>");

$sql = "SELECT start_time, license_number FROM scheduled WHERE mls_id=?";

// prepare and bind
$stmt = $conn->prepare($sql);

$stmt->bind_param('s', $parameter);

$stmt->execute();

$stmt->bind_result($start_time, $license_number);

while($stmt->fetch()) {
    echo("<div class='font'> Start time: " . $start_time . " License Number: " . $license_number . "</div>");
}    

echo("    
<p align=\"center\" class='font, end'> ~ end of results ~ </p>");

///////QUERY 2////////

echo("<h2 class='font'>Available Times</h2>");

$sql2 = "SELECT viewing.start_time FROM viewing LEFT OUTER JOIN scheduled ON (viewing.mls_id= scheduled.mls_id AND viewing.start_time = scheduled.start_time) WHERE scheduled.start_time IS NULL AND viewing.mls_id=?";

// prepare and bind
$stmt2 = $conn->prepare($sql2);

$stmt2->bind_param('s', $parameter);

$stmt2->execute();

$stmt2->bind_result($start_time);

while($stmt2->fetch()) {
    echo("<p class='font'>" . $start_time . "</p>");
}    
    
echo("    
<p align=\"center\" class='font, end'> ~ end of results ~ </p>");

echo("
    <div class='font'> 
        <h3 class='font'>Schedule a Viewing</h3>   
        <form action=\"add_viewing.php\" method=\"post\">
        <input type=\"hidden\" name=\"mls_id\" value=\"" . $parameter .  "\">
        <label for=\"start_time\"> Start Time: </label>
        <input type=\"text\" name=\"start_time\" />
        <label for=\"license_number\"> License Number: </label>
        <input type=\"text\" name=\"license_number\" />
        <input type=\"submit\" value=\"Submit\" name=\"Submit\" />
        </form>
        
        <br/>
        <h3 class='font'>Delete a Viewing</h3>
        <form action=\"delete_viewing.php\" method=\"post\">
        <input type=\"hidden\" name=\"mls_id\" value=\"" . $parameter .  "\">
        <label for=\"start_time\"> Start Time: </label>
        <input type=\"text\" name=\"start_time\" />
        <label for=\"license_number\"> License Number: </label>
        <input type=\"text\" name=\"license_number\" />
        <input type=\"submit\" value=\"Submit\" name=\"Submit\" />
        </form>
    </div>
");

?>
