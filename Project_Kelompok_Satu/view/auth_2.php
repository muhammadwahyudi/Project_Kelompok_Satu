<?php

$base_url = filter_input(INPUT_SERVER, "BaseView", FILTER_SANITIZE_URL);

if (!isset($_SESSION['s_username']) or empty($_SESSION['s_username'])) {
    header('location:' . $base_url . 'login.php');
}
if($_SESSION['s_role']!="super_admin"){
    header('location:' . $base_url . 'login.php');
}
if (filter_input(INPUT_GET, "url", FILTER_SANITIZE_STRING) == "logout") {
    session_destroy();
    header('location:' . $base_url . 'login.php');
}