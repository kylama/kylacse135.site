#!/usr/bin/ruby
require 'date'

puts "Content-Type: text/html\n"
puts <<~HTML
<!DOCTYPE html>
<html>
<head><title>Ruby Hello HTML</title></head>
<body>
    <h1 style="text-align: center">Hello, Ruby!</h1><hr/>
    <p>Hello! From Kyla</p>
    <p>This page was generated with the Ruby programming language</p>
    <p>This program was generated at: #{Time.now.strftime('%Y-%m-%d %H:%M:%S')}</p>
    <p>Your current IP Address is: #{ENV['REMOTE_ADDR']}</p>
</body>
</html>
HTML