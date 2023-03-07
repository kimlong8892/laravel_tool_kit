chown -R www-data:www-data *
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chown -R $USER:www-data .
chgrp -R www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
