<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_data'])) {
    $_SESSION['stored_info'] = htmlspecialchars($_POST['user_data']);
    header("Location: state-php-view.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP State Management - Set</title>

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
    <h1 style="text-align: center">Save Data to Session (PHP)</h1><hr/>
    <form action="state-php-set.php" method="POST">
        <p for="user_data">Enter information to store on the server:</p><br>
        <input type="text" id="user_data" name="user_data" required>
        <button type="submit">Save State</button>
    </form>
    <br>
    <nav>
        <a href="state-php-view.php">View Stored Data</a>
    </nav>
</body>
</html>