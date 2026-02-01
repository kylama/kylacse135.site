#!/usr/bin/python3
import os
from datetime import datetime

print("Content-Type: text/html\n")
print(f"""
<!DOCTYPE html>
<html>
<head>
    <title>Python Hello HTML</title>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-E1T0CZQWXH"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){{dataLayer.push(arguments);}}
    gtag('js', new Date());

    gtag('config', 'G-E1T0CZQWXH');
    </script>
      
    <script src="https://cdn.logr-in.com/LogRocket.min.js" crossorigin="anonymous"></script>
    <script>window.LogRocket && window.LogRocket.init('inhjvb/kylacse135site');</script>
</head>

<body>
    <h1 style="text-align: center">Hello, Python!</h1><hr/>
    <p>Hello! From Kyla</p>
    <p>This page was generated with the Python programming language</p>
    <p>This program was generated at: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}</p>
    <p>Your current IP Address is: {os.environ.get('REMOTE_ADDR')}</p>
</body>
</html>
""")