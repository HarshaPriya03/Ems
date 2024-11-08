<?php
//DB details
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'ems';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if($db->connect_error){
    die("Unable to connect database: " . $db->connect_error);
}
?>
<head>
    <link rel="shortcut icon" href="https://ik.imagekit.io/rzral9lq4/as/as/Anika_logo.png?ik-sdk-version=javascript-1.4.3&updatedAt=1677236863740" type="image/x-icon" width="" height="">
</head>