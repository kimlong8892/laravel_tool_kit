chown www-data:www-data  -R *
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chown $USER:$USER  -R *
chown www-data:www-data wp-content