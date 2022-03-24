<?php
    


    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecom";

    $connect = mysqli_connect($hostname, $username, $password, $dbname);

    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    };