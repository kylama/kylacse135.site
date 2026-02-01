<?php
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Hello HTML</title>

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
</head>

<body>
    <h1 style="text-align: center">Hello, PHP!</h1><hr/>
    <p>Hello! From Kyla</p>
    <p>This page was generated with the PHP programming language</p>
    <p>This program was generated at: <?php echo date('Y-m-d H:i:s'); ?></p>
    <p>Your current IP Address is: <?php echo $_SERVER['REMOTE_ADDR']; ?></p>
</body>
</html>