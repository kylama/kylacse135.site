# CSE 135 - Homework 1

## Deployment

- Hosted on DigitalOcean Droplet
- Apache Virtual Hosts
- Auto-deployed from GitHub via pull script (deploy.sh)

## URLS

- https://kylacse135.site
- https://kylacse135.site/members/kylama.html

## Password Protection

- Username: kyla
- Password: 49H&8#i^8eV%m!

## Compressing Textual Content

I enabled Apache's mod_deflate module, which resulted in the text files, such as the HTML, CSS, and JavaScript files, being compressed before being sent to the browser. I checked that it is compressing my files by using the Chrome DevTools (clicking Inspect). The Network tab shows that the server responds with a Content-Encoding: gzip header, meaning the files are being compressed. This results in the page loading more efficiently and a reduction in bandwidth usage.
