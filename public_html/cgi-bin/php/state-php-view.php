<?php
session_start();
$info = $_SESSION['stored_info'] ?? "No data saved yet.";
echo "<h1>Saved Data: $info</h1>";
echo '<a href="state-php-clear.php">Clear Data</a>';
?>