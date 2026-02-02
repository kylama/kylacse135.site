#!/usr/bin/ruby
require 'cgi'
require 'json'

cgi = CGI.new
cgi_bin_dir = File.expand_path('..', File.dirname(__FILE__))
session_file = File.join(cgi_bin_dir, 'sessions.json')

cookie_obj = cgi.cookies['stored_info']
cookie_data = (cookie_obj.respond_to?(:value) && cookie_obj.value) ? cookie_obj.value[0] : nil

fp_id = cgi['fp']
recovered_data = nil

if cookie_data
    message = "Found data via Cookie: <b>#{cookie_data}</b>"
elsif fp_id && !fp_id.empty?
    if File.exist?(session_file)
        sessions = JSON.parse(File.read(session_file))
        recovered_data = sessions[fp_id]
    end

    if recovered_data
        message = "Cookie, missing, Fingerprint recognized. Recovered: <b>#{recovered_data}</b>"
    else
        message = "No record found for this fingerprint."
    end
else
    message = "Identifying your device..."
end

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

    <script src='https://openfpcdn.io/fingerprintjs/v3/iife.min.js'></script>
    <script>
        window.addEventListener('load', () => {
            if (typeof FingerprintJS !== 'undefined') {
                const fpPromise = FingerprintJS.load();
                fpPromise
                    .then(fp => fp.get())
                    .then(result => {
                        const visitorId = result.visitorId;
      
                        const fpInput = document.getElementById('fingerprint_input');
                        if (fpInput) {
                            fpInput.value = visitorId;
                        }

                        const urlParams = new URLSearchParams(window.location.search);
                        const messageText = document.body.innerText;
                        if (messageText.includes("Identifying your device") && !urlParams.has('fp')) {
                            window.location.search = '?fp=' + visitorId;
                        }
      
                        console.log("Visitor Identifier:", visitorId);
                    })
                    .catch(error => console.error("Fingerprint error:", error));
            } else {
                console.error("FingerprintJS library failed to load.");
            }
        });
    </script>
</head>
<body>
    <h1 style="text-align: center">Server-Side Stored Data</h1><hr/>
    <p><strong>Stored Data:</strong> #{message}</p>
    <hr>
    <nav>
        <a href="state-ruby-set.rb">Change Data</a> | 
        <a href="state-ruby-clear.rb">Clear Session Data</a>
    </nav>
</body>
</html>
HTML