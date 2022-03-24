<?php
    $hostname = "173.212.235.205"; // online: 173.212.235.205 , local: localhost
    $username = "widnerco_admin"; // online: widnerco_admin , local: root
    $password = "!CodeFactory2022"; // online: !CodeFactory2022 , local: ""
    $dbname = "widnerco_ecom"; // online: widnerco_ecom , local: ecom

    $connect = mysqli_connect($hostname, $username, $password, $dbname);

    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    };