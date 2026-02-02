#!/usr/bin/ruby
require 'cgi'
require 'json'

cgi = CGI.new
cgi_bin_dir = File.expand_path('..', File.dirname(__FILE__))
session_file = File.json(cgi_bin_dir, 'sessions.json')

if cgi.request_method == "POST"
    user_data = cgi['user_data']
    fp_id = cgi['fingerprint_id']

    sessions = {}
    if File.exist?(session_file)
        begin
            sessions = JSON.parse(File.read(session_file))
        rescue
            sessions = {}
        end
    end

    if fp_id && !fp_id.empty?
        sessions[fp_id] = user_data
        File.write(session_file, JSON.generate(sessions))
    end

    cookie = CGI::Cookie.new('name' => 'stored_info', 'value' => user_data, 'path' => '/', 'expires' => Time.now + 3600)

    puts cgi.header('status' => '302 Found', 'location' => 'state-ruby-view.rb', 'cookie' => cookie)
    exit
end

puts "Content-Type: text/html\n\n"
puts <<~HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ruby State Management - Set</title>
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
    <h1 style="text-align: center">Save Data to Session (Ruby)</h1><hr/>
    <form action="state-ruby-set.rb" method="POST">
        <input type="hidden" id="fingerprint_input" name="fingerprint_id" value="">

        <p>Enter information to store on the server:</p><br>
        <input type="text" id="user_data" name="user_data" required>
        <button type="submit">Save State</button>
    </form>
    <br>
    <nav>
        <a href="state-ruby-view.rb">View Stored Data</a>
    </nav>
</body>
</html>
HTML