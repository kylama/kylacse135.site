#!/usr/bin/ruby
require 'cgi'

cgi = CGI.new
cookie = CGI::Cookie.new('name' => 'stored_info', 'value' => '', 'path' => '/', 'expires' => Time.now - 3600)

puts cgi.header('status' => '302 Found', 'location' => 'state-ruby-view.rb', 'cookie' => cookie)