Configuration on Debian
=======================

You need to configure apache and domain name, as follows:

1) In the file '/etc/hosts' add the following line '127.0.0.1 olapic'
2) In the file '/etc/apache2/sites-available/000-default.conf' add the following lines:

<VirtualHost *:80>
  DocumentRoot "/var/www/html/olapic/web"
  ServerName olapic
  <Directory "/var/www/html/olapic/web">
    AllowOverride All
  </Directory>
</VirtualHost>

Done! goto olapic/hello/your_name
