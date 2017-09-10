## Event Registration

Event Registration Form can be used for a free conference. It generates a voucher with a unique code that the user can print, and creates a user record with the collected data into an appropriately designed MySQL database table.


## Installation
For running up application you need php7, mysql.

For creating db and loading dump please use init forlder: there are some  scripts and .sql file.

```
bash init/init.sh
```

Please fill config/parameters.yml with your valid db credentials

Run composer install for loading dependencies:

```
curl -s http://getcomposer.org/installer | php
php composer.phar install
```

Give permissions on creation for your log folder: var/log

Up built-in php server:

```
php -S localhost:8008
```

After that you can open this link http://localhost:8008/public/app.php/registration and proceed with registration




