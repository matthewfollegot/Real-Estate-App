<?php
     $license_number = $_POST["license_number"];
     $start_time = $_POST["start_time"];
     $mls_id = $_POST["mls_id"];
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
    echo("<h2>Scheduled Viewings</h2>");

    $sql = "INSERT INTO scheduled (start_time, mls_id, license_number) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $start_time, $mls_id, $license_number);
    $stmt->execute();

    echo("<p>Viewing Added! Please return to previous page and refresh.<br>
            If you think there is an error, you entry must be invalid. Please check and try again.</p>");

    /*
    if($conn->query($sql) === TRUE) {
        header("Refresh:0");
    } else {
        echo("Error: " . $sql . "<br/>" . $conn->error);
    }
    */

?>