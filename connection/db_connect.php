<?php

    // Database configuration
    $host = 'localhost';
    $dbname = 'anh';
    $username = 'anh';
    $password = '9kCuzrb5tO53$xQtf';

    $conn = mysqli_connect($host, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    ini_set('display_startup_errors', 0);
?>