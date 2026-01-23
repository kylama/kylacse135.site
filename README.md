# CSE 135 - Homework 1

## Team Members

- Kyla Ma

## User "grader" Password

E95%r9qeNK%uX#

## Link to Site

https://kylacse135.site

## Deployment

- Hosted on DigitalOcean Droplet
- Apache Virtual Hosts
- Auto-deployed from GitHub via pull script (deploy.sh)

## Password Protection

- Username: kyla
- Password: 49H&8#i^8eV%m!

## Compressing Textual Content

I enabled Apache's mod_deflate module, which resulted in the text files, such as the HTML, CSS, and JavaScript files, being compressed before being sent to the browser. I checked that it is compressing my files by using the Chrome DevTools (clicking Inspect). The Network tab shows that the server responds with a Content-Encoding: gzip header, meaning the files are being compressed. This results in the page loading more efficiently and a reduction in bandwidth usage.

## Obscuring Server Identity

To change the Server: header to read "Server: CSE135 Server", I used ModSecurity to rewrite headers which Apache normally protects. First, I installed ModSecurity to make sure I could use it on my server. Then, I navigated to the /etc/apache2/conf-available/security.conf file and changed the "ServerTokens OS" to "ServerTokens Full", which enables ModSecurity to to completely rewrite the string. Then, I went to /etc/apache2/mods-available/security2.conf to specify the exact string to be in the header by adding the line "SecServerSignature "CSE135 Server"" to the bottom of the file.
