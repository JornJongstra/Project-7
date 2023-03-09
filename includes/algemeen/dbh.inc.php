<?php

$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "project-7";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}