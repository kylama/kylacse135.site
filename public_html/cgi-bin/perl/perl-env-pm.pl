#!/usr/bin/perl

# The below line includes the CGI.pm Perl library
use CGI qw/:standard/;     

# CGI.pm Method
print "Cache-Control: no-cache\n";
print header;

my $google_tag = <<'TAG';
<script async src="https://www.googletagmanager.com/gtag/js?id=G-E1T0CZQWXH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-E1T0CZQWXH');
</script>
TAG

# CGI.pm Method
print start_html(
   -title => "Environment Variables",
   -head => $google_tag
);

print "<h1 align='center'>Environment Variables</h1><hr />";

# Loop through all of the environment variables, then print each variable and its value
foreach my $key (sort(keys(%ENV))) {
   print  "$key = $ENV{$key}<br />\n";
}

# CGI.pm method
print end_html;
