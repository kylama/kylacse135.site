#!/usr/bin/ruby
require 'cgi'

cgi = CGI.new
user_data = cgi['user-data']

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