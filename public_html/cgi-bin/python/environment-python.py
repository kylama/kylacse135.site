#!/usr/bin/python3
import os

print("Content-Type: text/html\n")

print(f"""
<!DOCTYPE html>
<html><head><title>Environment Variables</title>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-E1T0CZQWXH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){{dataLayer.push(arguments);}}
  gtag('js', new Date());

  gtag('config', 'G-E1T0CZQWXH');
</script>
</head><body><h1 style="text-align: center">Environment Variables</h1>
<hr>
""")
for key, value in os.environ.items():
    print(f"<strong>{key}:</strong> {value}<br />")
print("</body></html>")