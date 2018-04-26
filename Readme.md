# FFUF Default APP

## Before Starting

### composer.json

- change name

```json
	"name": "ffuf/APPLICATION_NAME"
```

- change the author information

```json
	"authors": [
        {
            "name": "Firstname Lastname",
            "email": "fistname.lastname@ffuf.de"
        }
    ]
```

- change namespace

```json
	"autoload": {
        "psr-4": {
            "ffuf\\customer\\project\\": ""
        }
    }
```
### config/php.config.php

Change:

```php
define('APPLICATION_NAME', 'application_name');
```

### config/app/

Place all your application replated config files in this folder!
Prefix them with an increment value (e.g. 01-api.php, 02-docraptor.php, 03-mail.php).

Set the DB-Credentials in 00-db.php

```php
    $entityManager = \Doctrine\ORM\EntityManager::create(array(
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => 'root',
        'dbname' => 'test',
        'host' => '127.0.0.1',
        'connection' => array('compress' => 'true'),
        'driverOptions' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        )
    ), $entityManagerConfig);
```


### composer

- composer install --no-dev

