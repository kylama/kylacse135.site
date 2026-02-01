<?php
session_start();
$info = $_SESSION['stored_info'] ?? "No data currently saved in the session.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP State Management - View</title>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-E1T0CZQWXH"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-E1T0CZQWXH');
    </script>
</head>

<body>
    <h1 style="text-align: center">Server-Side Stored Data</h1><hr/>
    <p><strong>Stored Data:</strong> <?php echo $info; ?></p>
    <hr>
    <nav>
        <a href="state-php-set.php">Change Data</a> | 
        <a href="state-php-clear.php">Clear Session Data</a>
    </nav>
</body>
</html>