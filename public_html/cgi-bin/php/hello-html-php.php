<?php
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html>
<head><title>PHP Hello HTML</title></head>
<body>
    <h1>Hello! From Kyla</h1>
    <p>This page was generated with the PHP programming language</p>
    <p>This program was generated at: <?php echo date('Y-m-d H:i:s'); ?></p>
    <p>Your current IP Address is: <?php echo $_SERVER['REMOTE_ADDR']; ?></p>
</body>
</html>