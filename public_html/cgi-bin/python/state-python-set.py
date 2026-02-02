#!/usr/bin/python3
import os
import sys
import urllib.parse
import json
from http import cookies

cgi_bin_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
SESSION_FILE = os.path.join(cgi_bin_dir, "sessions.json")

if os.environ.get('REQUEST_METHOD') == 'POST':
    storage = sys.stdin.read()
    post_data = urllib.parse.parse_qs(storage)

    user_data = post_data.get('user_data', [''])[0]
    fp_id = post_data.get('fingerprint_id', [''])[0]

    sessions = {}
    if os.path.exists(SESSION_FILE):
        with open(SESSION_FILE, "r") as f:
            try: sessions = json.load(f)
            except: sessions = {}

    if fp_id:
        sessions[fp_id] = user_data
        with open(SESSION_FILE, "w") as f:
            json.dump(sessions, f)

    c = cookies.SimpleCookie()
    c['stored_info'] = user_data
    c['stored_info']['path'] = '/'

    print(c.output())
    print("Location: state-python-view.py\n")
    sys.exit()

print("Content-Type: text/html\n\n")
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
      
    <script src='https://openfpcdn.io/fingerprintjs/v3/iife.min.js'></script>
    <script>
        window.addEventListener('load', () => {{
            if (typeof FingerprintJS !== 'undefined') {{
                const fpPromise = FingerprintJS.load();
                fpPromise
                    .then(fp => fp.get())
                    .then(result => {{
                        const visitorId = result.visitorId;
      
                        const fpInput = document.getElementById('fingerprint_input);
                        if (fpInput) {{
                            fpInput.value = visitorId;
                        }}

                        const urlParams = new URLSearchParams(window.location.search);
                        const messageText = document.body.innerText;
                        if (messageText.includes("Identifying your device") && !urlParams.has('fp')) {{
                            window.location.search = '?fp=' + visitorId;
                        }}
      
                        console.log("Visitor Identifier:", visitorId);
                    }})
                    .catch(error => console.error("Fingerprint error:", error));
            }} else {{
                console.error("FingerprintJS library failed to load.");
            }}
        }});
    </script>
</head>
<body>
    <h1 style="text-align: center">Save Data to Session (Python)</h1><hr/>
    <form action="state-python-set.py" method="POST">
        <input type="hidden" id="fingerprint_input" name="fingerprint_id" value="">
      
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