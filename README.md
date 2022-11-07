# Gamecity

### Requirements
* [Docker](https://docs.docker.com/engine/installation/)

## Local setup with Lando

### Clone Gamecity repo
``` sh
$ git clone https://github.com/michaelocana/gamecity.git gamecity.local
```
### Create settings.local.php
``` sh
$ cd gamecity
$ nano gamecity.local/gamecity/web/sites/default/settings.local.php
```
Add this code to settings.local.php
``` sh
<?php

$databases['default']['default'] = array (
  'database' => 'drupal9',
  'username' => 'drupal9',
  'password' => 'drupal9',
  'prefix' => '',
  'host' => 'database',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);

$settings['hash_salt'] = 'DUMMY_DEV_HASH';

$cookie_domain = '.localhost';
```
### Build the project image
``` sh
$ lando start
```
### Import the Database
``` sh
$ cd gamecity.local/gamecity
$ lando db-import dump/gamecity.sql
```
### Build project
``` sh
$ lando drush cr
$ lando drush cim -y
$ lando drush updb -y
$ lando drush cr 
```
### Ready to go!
``` sh
Open browser: http://gamecity.lndo.site/
```

### 1.2.1 Games API Query
``` sh

	var settings = {
	  "url": "http://gamecity.lndo.site/api/v1/gamecity?category=puzzle",
	  "method": "GET",
	  "timeout": 0,
	  "headers": {
	    "Content-Type": "application/json",
	    "X-CSRF-Token": "vnJvTj7OskmVLUAtvbZThx-bFmh2XrgSluN4zLNApzw"
	  },
	};

	$.ajax(settings).done(function (response) {
	  console.log(response);
	});

	Implemented using views : http://gamecity.lndo.site/admin/structure/views/view/gamecity
```

### Category
``` sh
  puzzle, action, arcade
```

### 1.2.2 Add Games via API
``` sh
	var settings = {
	  "url": "http://gamecity.lndo.site/api/v1/gamecity/add/game?_format=json",
	  "method": "POST",
	  "timeout": 0,
	  "headers": {
	    "Content-Type": "application/json"
	  },
	  "data": JSON.stringify({
	    "title": "test3",
	    "description": "this is description",
	    "category": "puzzle"
	  }),
	};

	$.ajax(settings).done(function (response) {
	  console.log(response);
	});


	Implemented using rest module : http://gamecity.lndo.site/admin/config/services/rest/resource/api_gamecity_add/edit and resource custom module.
```

### 2 API Configuration form
```
admin > configuration > Gamecity API Settings
http://gamecity.lndo.site/admin/gamecity/api/settings
```
