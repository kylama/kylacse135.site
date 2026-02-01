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
</head>
<body>
    <h1 style="text-align: center">Save Data to Session (PHP)</h1><hr/>
    <form action="state-php-set.php" method="POST">
        <label for="user_data">Enter information to store on the server:</label><br><br>
        <input type="text" id="user_data" name="user_data" required>
        <button type="submit">Save State</button>
    </form>
    <br>
    <nav>
        <a href="state-php-view.php">View Stored Data</a>
    </nav>
</body>
</html>