<?php
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html><head><title>Environment Variables</title>
</head><body><h1 style="text-align: center">Environment Variables</h1>
<hr>
<?php
foreach ($_SERVER as $key => $value) {
    echo "<strong>$key:</strong> $value<br />";
}
?>
</body></html>