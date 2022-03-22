<?php
session_start();
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
} else if (isset($_SESSION['user'])) {
    header("Location: index.php");
} else if (isset($_SESSION['adm'])) {
    header("Location: index.php");
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    unset($_SESSION['adm']);
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}