<?php

return array(
	'connections' => array(
		'mysql' => array(
			'driver' => 'mysql',
			'host' => getenv('db_host'),
			'database' => getenv('db_name'),
			'username' => getenv('db_username'),
			'password' => getenv('db_password'),
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => '',
		)
	)
);
