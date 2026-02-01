#!/usr/bin/perl

print "Cache-Control: no-cache\n";
print "Content-Type: text/html\n\n";

print "<!DOCTYPE html>";
print "<html>";
print "<head>";

print "<title>Kyla's Hello CGI World</title>";

print "<script async src='https://www.googletagmanager.com/gtag/js?id=G-E1T0CZQWXH'></script>";
print "<script>";
print "window.dataLayer = window.dataLayer || [];";
print "function gtag(){dataLayer.push(arguments);}";
print "gtag('js', new Date());";
print "gtag('config', 'G-E1T0CZQWXH');";
print "</script>";

print "<script src='https://cdn.logr-in.com/LogRocket.min.js' crossorigin='anonymous'></script>";
print "<script>window.LogRocket && window.LogRocket.init('inhjvb/kylacse135site');</script>";

print "</head>";

print "<body>";

print "<h1 align=center>Kyla's Hello HTML World</h1><hr/>";
print "<p>Hello World! From Kyla</p>";
print "<p>This page was generated with the Perl programming langauge</p>";

$date = localtime();
print "<p>This program was generated at: $date</p>";

# IP Address is an environment variable when using CGI
$address = $ENV{REMOTE_ADDR};
print "<p>Your current IP Address is: $address</p>";

print "</body>";
print "</html>";
