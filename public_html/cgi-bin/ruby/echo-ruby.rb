#!/usr/bin/ruby

require 'json'
require 'cgi'

puts "Content-Type: application/json\n\n"

method = ENV['REQUEST_METHOD']
payload = STDIN.read

response = {
    hostname: `hostname`.strip,
    datetime: Time.now.strftime('%Y-%m-%d %H:%M:%S'),
    user_agent: ENV['HTTP_USER_AGENT'],
    IP_address: ENV['REMOTE_ADDR'],
    method: method,
    payload: payload
}

puts JSON.pretty_generate(response)