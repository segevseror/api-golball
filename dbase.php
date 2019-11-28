<?php

$servername = "ec2-54-217-234-157.eu-west-1.compute.amazonaws.com";
$dbname = 'dav5nd421ipu74';
$username = "lfpegwcrzqkfgp";
$password = "52bc85c5bec01bb9563d98e20dcad713319986829d6321939892fe4f3787227c";

try {
    $conn = new PDO("mysql:host=$servername;dbname=".$dbname, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


die('das');