date=$(date '+%Y-%m-%d %H:%M:%S')
docker exec wordpress_db_server /usr/bin/mysqldump -u admin --password=Admin123 wordpress > app/wordpress/sql.sql
docker exec laravel_db_server /usr/bin/mysqldump -u admin --password=Admin123 laravel > app/laravel/sql.sql
mkdir -p backup
zip -r "backup/$date.zip" /var/www/html/laravel_tool_kit/app/wordpress/wp-content/uploads /var/www/html/laravel_tool_kit/app/wordpress/sql.sql /var/www/html/laravel_tool_kit/app/laravel/public/images_upload  /var/www/html/laravel_tool_kit/app/laravel/sql.sql
rm -rf app/wordpress/sql.sql
rm -rf app/laravel/sql.sql