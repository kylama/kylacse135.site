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

    <script src="https://cdn.logr-in.com/LogRocket.min.js" crossorigin="anonymous"></script>
    <script>window.LogRocket && window.LogRocket.init('inhjvb/kylacse135site');</script>

    <script defer src="https://cloud.umami.is/script.js" data-website-id="c551fd6b-f42b-4084-af35-65fec427992b"></script>
</head>

<body><h1 style="text-align: center">Environment Variables</h1>
<hr>
<?php
foreach ($_SERVER as $key => $value) {
    echo "<strong>$key:</strong> $value<br />";
}
?>
</body></html>