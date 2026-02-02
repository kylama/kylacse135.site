#!/usr/bin/python3
import os, json, urllib.parse
from http import cookies

cgi_bin_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
SESSION_FILE = os.path.join(cgi_bin_dir, "sessions.json")

c = cookies.SimpleCookie(os.environ.get("HTTP_COOKIE", ''))
cookie_data = c.get("stored_info").value if c.get("stored_info") else None

query = urllib.parse.parse_qs(os.environ.get('QUERY_STRING', ''))
fp_id = query.get('fp', [''])[0]

recovered_data = None
message = ""

if cookie_data:
    message = f"Found data via Cookie: <b>{cookie_data}</b>"
elif fp_id:
    if os.path.exists(SESSION_FILE):
        with open(SESSION_FILE, "r") as f:
            sessions = json.load(f)
            recovered_data = sessions.get(fp_id)

    if recovered_data:
        message = f"Cookie missing, Fingerprint recognized. Recovered: <b>{recovered_data}</b>"
    else:
        message = "No cookie or fingerprint record found."
else:
    message = "Identifying your device..."

print("Content-Type: text/html\n\n")
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
    <h1 style="text-align: center">Server-Side Stored Data</h1><hr/>
    <p><strong>Stored Data:</strong> <br />{message}</p>
    <hr>
    <nav>
        <a href="state-python-set.py">Change Data</a> | 
        <a href="state-python-clear.py">Clear Session Data</a>
    </nav>
</body>
</html>
""")