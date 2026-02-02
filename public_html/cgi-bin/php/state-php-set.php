<?php
session_start();

$cgi_bin_dir = dirname(__DIR__);
$session_file = $cgi_bin_dir . "/sessions.json";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_data'])) {
    $user_data = htmlspecialchars($_POST['user_data']);
    $fp_id = $_POST['fingerprint_id'] ?? '';

    $_SESSION['stored_info'] = $user_data;

    setcookie("stored_info", $user_data, time() + 3600, "/");

    if(!empty($fp_id)) {
        $sessions = [];
        if (file_exists($session_file)) {
            $sessions = json_decode(file_get_contents($session_file), true) ?? [];
        }
        $sessions[$fp_id] = $user_data;
        file_put_contents($session_file, json_encode($sessions));
    }

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

    <script src="https://cdn.logr-in.com/LogRocket.min.js" crossorigin="anonymous"></script>
    <script>window.LogRocket && window.LogRocket.init('inhjvb/kylacse135site');</script>

    <script defer src="https://cloud.umami.is/script.js" data-website-id="c551fd6b-f42b-4084-af35-65fec427992b"></script>

    <script src='https://openfpcdn.io/fingerprintjs/v3/iife.min.js'></script>
    <script>
        window.addEventListener('load', () => {
            if (typeof FingerprintJS !== 'undefined') {
                const fpPromise = FingerprintJS.load();
                fpPromise
                    .then(fp => fp.get())
                    .then(result => {
                        const visitorId = result.visitorId;
      
                        const fpInput = document.getElementById('fingerprint_input');
                        if (fpInput) {
                            fpInput.value = visitorId;
                        }

                        const urlParams = new URLSearchParams(window.location.search);
                        const messageText = document.body.innerText;
                        if (messageText.includes("Identifying your device") && !urlParams.has('fp')) {
                            window.location.search = '?fp=' + visitorId;
                        }
      
                        console.log("Visitor Identifier:", visitorId);
                    })
                    .catch(error => console.error("Fingerprint error:", error));
            } else {
                console.error("FingerprintJS library failed to load.");
            }
        });
    </script>
</head>

<body>
    <h1 style="text-align: center">Save Data to Session (PHP)</h1><hr/>
    <form action="state-php-set.php" method="POST">
        <input type="hidden" id="fingerprint_input" name="fingerprint_id" value="">

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