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