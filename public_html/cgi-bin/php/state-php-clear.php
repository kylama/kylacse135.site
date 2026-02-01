<?php
session_start();
unset($_SESSION['stored_info']);
header("Location: state-php-view.php");
exit();
?>