# CSE 135 - Homework 1

## Team Members

- Kyla Ma

## User "grader" Password

E95%r9qeNK%uX#

## Link to Site

https://kylacse135.site

## Details of Github Auto Deploy Setup

To set up my site to deploy from Github, I first copied the files from my server into an empty repository on Github, then pulled from that repository to my local machine. Then, I also pulled from the same Github repository to my server, deleting the files that existed before. To make sure that my site had automatic deployments that reflected changes pushed from my local machine, I created a deploy.sh file and wrote a script that pulled changes from main. I had to set up Github Actions with secrets containing my Droplet's IP Address, SSH key, and username to make sure that the script ran automatically after a push to the repository.

## Username/Password for Site Login

- My Username: kyla
- My Password: 49H&8#i^8eV%m!

- Grader Username: grader
- Grader Password: Y9zkTyg$6mo^%!

## Summary of Changes to HTML file in DevTools after Compression

I enabled Apache's mod_deflate module, which resulted in the text files, such as the HTML, CSS, and JavaScript files, being compressed before being sent to the browser. I checked that it is compressing my files by using the Chrome DevTools (clicking Inspect). The Network tab shows that the server responds with a Content-Encoding: gzip header, meaning the files are being compressed. The size column also shows that the transfer size was reduced compared to the original file size. This results in the page loading more efficiently and a reduction in bandwidth usage.

## Summary of Removing 'Server' Header

To change the Server: header to read "Server: CSE135 Server", I used ModSecurity to rewrite headers which Apache normally protects. First, I installed ModSecurity to make sure I could use it on my server. Then, I navigated to the /etc/apache2/conf-available/security.conf file and changed the "ServerTokens OS" to "ServerTokens Full", which enables ModSecurity to to completely rewrite the string. Then, I went to /etc/apache2/mods-available/security2.conf to specify the exact string to be in the header by adding the line "SecServerSignature "CSE135 Server"" to the bottom of the file.
