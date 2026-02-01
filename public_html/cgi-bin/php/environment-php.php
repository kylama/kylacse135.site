<?php
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html><head><title>Environment Variables</title>
</head><body><h1 style="text-align: center">Environment Variables</h1>
<hr>
<?php
echo "<h1>Environment Variables</h1><ul>";
foreach ($_SERVER as $key => $value) {
    echo "<li><strong>$key:</strong> $value</li>";
}
echo "</ul>";
?>
</body></html>