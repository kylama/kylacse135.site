#!/usr/bin/ruby
require 'cgi'

cgi = CGI.new
user_data = cgi['user_data']

if ENV['REQUEST_METHOD'] == 'POST' && !user_data.empty?
    cookie = CGI::Cookie.new('name' => 'stored_info', 'value' => user_data, 'path' => '/')
    puts cgi.header('cookie' => cookie, 'type' => 'text/html', 'status' => 'REDIRECT', 'location' => 'state-ruby-view.rb')
else
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
        <h1 style="text-align: center">Save Data to Session (Ruby)</h1><hr/>
        <form action="state-ruby-set.rb" method="POST">
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
end