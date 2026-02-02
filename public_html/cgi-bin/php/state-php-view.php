<?php
session_start();

$cgi_bin_dir = dirname(__DIR__);
$session_file = $cgi_bin_dir . "/sessions.json";

$info = $_SESSION['stored_info'] ?? null;
$method = "Session";

if (!$info && isset($_COOKIE['stored_info'])) {
    $info = $_COOKIE['stored_info'];
    $method = "Persistent Cookie";
}

$fp_id = $_GET['fp'] ?? null;
if (!$info && $fp_id) {
    if (file_exists($session_file)) {
        $sessions = json_decode(file_get_contents($session_file), true) ?? [];
        if (isset($sessions[$fp_id])) {
            $info = $sessions[$fp_id];
            $method = "Fingerprint Shadow Session";
        }
    }
}

if ($info) {
    $display_message = "Found data via $method: <b>" . htmlspecialchars($info) . "</b>";
} else {
    $display_message = "Identifying your device...";
}
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
    <h1 style="text-align: center">Server-Side Stored Data</h1><hr/>
    <p><strong>Stored Data:</strong> <?php echo $display_message; ?></p>
    <hr>
    <nav>
        <a href="state-php-set.php">Change Data</a> | 
        <a href="state-php-clear.php">Clear Session Data</a>
    </nav>
</body>
</html>