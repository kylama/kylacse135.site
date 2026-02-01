<?php
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html><head>
    <title>Environment Variables</title>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-E1T0CZQWXH"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-E1T0CZQWXH');
    </script>
</head>

<body><h1 style="text-align: center">Environment Variables</h1>
<hr>
<?php
foreach ($_SERVER as $key => $value) {
    echo "<strong>$key:</strong> $value<br />";
}
?>
</body></html>