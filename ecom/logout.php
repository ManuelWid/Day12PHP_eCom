<?php
session_start();
if (!isset($_SESSION['adm']) && !isset($_SESSION['user']) && !isset($_SESSION['sup'])) {
    header("Location: index.php");
    exit;
} else if (isset($_SESSION)) {
    header("Location: index.php");
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    unset($_SESSION['adm']);
    unset($_SESSION['sup']);
    unset($_SESSION['fk_sup_id']);
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}