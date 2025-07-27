# Campstagram
a simple image-sharing website to be hosted on a Raspberry Pi

Made for the [WHY2025](https://why2025.org/) dutch hacker camp.
It hosts a simple website with a vertical list of all uploaded pictures and provides a simple form for users to upload pictures and a bit of text (max 200 characters).
The description gets saved as the pictures's name and all the pictures are stored locally.

## Setup
1. install apache2 and php (try [this tutorial](https://gist.github.com/QasimTalkin/9c727739653ceab0f50156548d94a833#change-directory-to-public-html-and-grant-ownership-to-pi-user))
3. put the html-, css- and php-files into the /var/www/html directory
4. create the /var/www/html/pictures directory (this is where the uploaded pictures get stored)
5. give ownership to the php user so that upload.php can write to the pictures directory (have a look at [this](https://stackoverflow.com/questions/2900690/how-do-i-give-php-write-access-to-a-directory))
