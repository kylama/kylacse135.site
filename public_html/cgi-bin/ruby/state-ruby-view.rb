#!/usr/bin/ruby
require 'cgi'

cgi = CGI.new
cookie = cgi.cookies['stored_info']
info = cookie.empty? ? "No data currently saved in the session." : cookie.value[0]

puts "Content-Type: text/html\n\n"
puts <<~HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ruby State Management - View</title>
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

    <script>
        window.addEventListener('load', () => {
            const fpPromise = FingerprintJS.load();

            fpPromise
                .then(fp => fp.get())
                .then(result => {
                    const visitorId = result.visitorId;
                    const fpInput = document.getElementById('fingerprint_input');
                    if (fpInput) {
                        fpInput.value = visitorId;
                    }
                    console.log("Visitor Identifier:", visitorId);
                });
        });
    </script>
</head>
<body>
    <h1 style="text-align: center">Server-Side Stored Data</h1><hr/>
    <p><strong>Stored Data:</strong> #{info}</p>
    <hr>
    <nav>
        <a href="state-ruby-set.rb">Change Data</a> | 
        <a href="state-ruby-clear.rb">Clear Session Data</a>
    </nav>
</body>
</html>
HTML