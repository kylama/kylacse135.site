#!/usr/bin/ruby
require 'cgi'

cgi = CGI.new
cookie = CGI::Cookie.new('name' => 'stored_info', 'value' => '', 'path' => '/', 'expires' => Time.at(0))

puts cgi.header('cookie' => cookie, 'type' => 'text/html', 'status' => 'REDIRECT', 'location' => 'state-ruby-view.rb')