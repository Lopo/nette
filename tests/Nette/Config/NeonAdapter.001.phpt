<?php

/**
 * Test: Nette\Config\NeonAdapter
 *
 * @author     David Grudl
 * @package    Nette\Config
 * @subpackage UnitTests
 */

use Nette\Config\Config;



require __DIR__ . '/../bootstrap.php';

define('TEMP_FILE', TEMP_DIR . '/cfg.neon');


// Load
$config = Config::fromFile('config1.neon');
Assert::equal( Nette\ArrayHash::from(array(
	'production' => array(
		'webname' => 'the example',
		'database' => array(
			'adapter' => 'pdo_mysql',
			'params' => array(
				'host' => 'db.example.com',
				'username' => 'dbuser',
				'password' => 'secret',
				'dbname' => 'dbname',
			),
		),
	),
	'development' => array(
		'database' => array(
			'params' => array(
				'host' => 'dev.example.com',
				'username' => 'devuser',
				'password' => 'devsecret',
				'dbname' => 'dbname',
			),
			'adapter' => 'pdo_mysql',
		),
		'timeout' => 10,
		'display_errors' => TRUE,
		'html_errors' => FALSE,
		'items' => array(
			10,
			20,
		),
		'webname' => 'the example',
	),
), TRUE), $config );



// Save INI
Config::save($config, TEMP_FILE);
Assert::match( <<<EOD
# generated by Nette

production:
	webname: the example
	database:
		adapter: pdo_mysql
		params:
			host: db.example.com
			username: dbuser
			password: secret
			dbname: dbname



development:
	database:
		params:
			host: dev.example.com
			username: devuser
			password: devsecret
			dbname: dbname

		adapter: pdo_mysql

	timeout: 10
	display_errors: true
	html_errors: false
	items:
		- 10
		- 20

	webname: the example
EOD
, file_get_contents(TEMP_FILE) );
