#!/usr/bin/ruby

puts "Content-Type: text/html\n\n"
puts <<~HTML
<!DOCTYPE html>
<html><head><title>Environment Variables</title>
</head><body><h1 style="text-align: center">Environment Variables</h1>
<hr>
HTML
ENV.each do |key, value|
    puts "<strong>#{key}:</strong> #{value}<br />"
end
puts "</body></html>"