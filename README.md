# Campstagram
a simple image-sharing website to be hosted on a Raspberry Pi

Made for the [WHY2025](https://why2025.org/) dutch hacker camp.
It hosts a simple website with a vertical list of all uploaded pictures and provides a simple form for users to upload pictures and a bit of text (max 200 characters).
The description gets saved as the pictures's name and all the pictures are stored locally.

## Setup
1. install apache2 and php (try [this tutorial](https://gist.github.com/QasimTalkin/9c727739653ceab0f50156548d94a833#change-directory-to-public-html-and-grant-ownership-to-pi-user))
2. go to `/var/www`
3. clone the repo
4. open `/etc/apache2/sites-available/000-default.conf`
5. set `DocumentRoot` to `/var/www/Campstagram`
6. restart apache
7. run `sudo chown -R www-data:www-data /var/www/Campstagram` to make sure upload.php can create and write to the pictures directory
