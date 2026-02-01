#!/usr/bin/ruby
require 'json'
require 'date'

puts "Content-Type: application/json\n"

data = {
    title: "Ruby Hello JSON",
    heading: "Hello, Ruby!",
    message: "This page was generated with the Ruby programming language",
    time: Time.now.strftime('%Y-%m-%d %H:%M:%S'),
    IP: ENV['REMOTE_ADDR']
}

puts JSON.generate(data)