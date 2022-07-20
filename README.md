After cloning the project

composer install
npm install
create database in mysql
cp .env.example .env
nano .env
php artisan key:generate
php artisan migrate
php artisan route:cache
php artisan view:cache
php artisan config:cache
php artisan run dev
php artisan storage:link

<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot "/var/www/html/contents/public"
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

  <Directory "/var/www/html/contents/public">
                 Options Indexes FollowSymLinks Includes ExecCGI
                 AllowOverride All
                 Require all granted
  </Directory>
</VirtualHost>

chmod 775 /var/www/html/contents
chown -R www-data.www-data /var/www/html/contents
service apache2 restart