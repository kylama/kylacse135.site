<?php
session_start();
if (isset($_POST['user_data'])) {
    $_SESSION['stored_info'] = $_POST['user_data'];
}
header("Location: state-php-view.php")
?>