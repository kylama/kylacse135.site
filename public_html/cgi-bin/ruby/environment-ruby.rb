#!/usr/bin/ruby

puts "Content-Type: text/html\n\n"
puts <<~HTML
<!DOCTYPE html>
<html><head><title>Environment Variables</title>
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
</head><body><h1 style="text-align: center">Environment Variables</h1>
<hr>
HTML
ENV.each do |key, value|
    puts "<strong>#{key}:</strong> #{value}<br />"
end
puts "</body></html>"