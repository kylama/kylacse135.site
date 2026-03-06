<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'password123') {
        $_SESSION['user_id'] = 'admin_user';
        header("Location: /dashboard");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reporting Login</title>
</head>
<body>
	<h1>Reporting Login</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

	<form id="login-form" action="/login" method="POST">
		<div>
            <label for="username">Username: </label>
            <input type="text" id="username" name="username" required>
        </div>

        <div>
            <label for="password">Password: </label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <button type="submit" id="loginBtn">Login</button>
        </div>
	</form>
</body>
</html>
