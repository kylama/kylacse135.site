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

    <script src="https://cdn.logr-in.com/LogRocket.min.js" crossorigin="anonymous"></script>
    <script>window.LogRocket && window.LogRocket.init('inhjvb/kylacse135site');</script>

    <script defer src="https://cloud.umami.is/script.js" data-website-id="c551fd6b-f42b-4084-af35-65fec427992b"></script>

    <script src='https://openfpcdn.io/fingerprintjs/v5' defer></script>
    <script>
        window.addEventListener('load', () => {
            const fpPromise = FingerprintJS.load();

            fpPromise
                .then(fp => fp.get())
                .then(result => {
                    const visitorId = result.visitorId;
                    const fpInput = document.getElementById('fingerprint_input');
                    if (fpInput) {
                        fpInput.value = visitorId;
                    }
                    console.log("Visitor Identifier:", visitorId);
                });
        });
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