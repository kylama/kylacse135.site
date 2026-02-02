#!/usr/bin/python3
import os
import sys
import urllib.parse
from http import cookies

if os.environ.get('REQUEST_METHOD') == 'POST':
    storage = sys.stdin.read()
    post_data = urllib.parse.parse_qs(storage)

    if 'user_data' in post_data:
        user_info = post_data['user_data'][0]

        c = cookies.SimpleCookie()
        c['stored_info'] = user_info
        c['stored_info']['path'] = '/'

        print(c.output())
        print("Location: state-python-view.py\n")
        sys.exit()

print("Content-Type: text/html\n")
print(f"""
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Python State Management - Set</title>
      
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
    <h1 style="text-align: center">Save Data to Session (Python)</h1><hr/>
    <form action="state-python-set.py" method="POST">
        <p>Enter information to store on the server:</p><br>
        <input type="text" id="user_data" name="user_data" required>
        <button type="submit">Save State</button>
    </form>
    <br>
    <nav>
        <a href="state-python-view.py">View Stored Data</a>
    </nav>
</body>
</html>
""")