#!/usr/bin/python3
import os
from datetime import datetime

print("Content-Type: text/html\n\n")
print(f"""
<!DOCTYPE html>
<html>
<head><title>Python Hello HTML</title></head>
<body>
    <h1 style="text-align: center">Hello HTML World</h1><hr/>
    <p>Hello! From Kyla</p>
    <p>This page was generated with the Python programming language</p>
    <p>This program was generated at: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}</p>
    <p>Your current IP Address is: {os.environ.get('REMOTE_ADDR')}</p>
</body>
</html>
""")