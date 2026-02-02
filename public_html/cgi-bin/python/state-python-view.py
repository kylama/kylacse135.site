#!/usr/bin/python3
import os
from http import cookies

print("Content-Type: text/html\n")
c = cookies.SimpleCookie(os.environ.get("HTTP_COOKIE", ''))
info = c["stored_info"].value if "stored_info" in c else "No data currently saved in the session."

print(f"""
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Python State Management - View</title>
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-E1T0CZQWXH"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){{dataLayer.push(arguments);}}
    gtag('js', new Date());

    gtag('config', 'G-E1T0CZQWXH');
    </script>
      
    <script src="https://cdn.logr-in.com/LogRocket.min.js" crossorigin="anonymous"></script>
    <script>window.LogRocket && window.LogRocket.init('inhjvb/kylacse135site');</script>
      
    <script defer src="https://cloud.umami.is/script.js" data-website-id="c551fd6b-f42b-4084-af35-65fec427992b"></script>
      
    <script src='https://openfpcdn.io/fingerprintjs/v5' defer></script>
    <script>
        window.addEventListener('load', () => {{
            const fpPromise = FingerprintJS.load();

            fpPromise
                .then(fp => fp.get())
                .then(result => {{
                    const visitorId = result.visitorId;
                    const fpInput = document.getElementById('fingerprint_input');
                    if (fpInput) {{
                        fpInput.value = visitorId;
                    }}
                    console.log("Visitor Identifier:", visitorId);
                }});
        }});
    </script>
</head>
<body>
    <h1 style="text-align: center">Server-Side Stored Data</h1><hr/>
    <p><strong>Stored Data:</strong> {info}</p>
    <hr>
    <nav>
        <a href="state-python-set.py">Change Data</a> | 
        <a href="state-python-clear.py">Clear Session Data</a>
    </nav>
</body>
</html>
""")