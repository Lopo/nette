<?php

/**
 * Test: Nette\Application\Routers\CliRouter invalid argument
 *
 * @author     David Grudl
 * @package    Nette\Application
 * @subpackage UnitTests
 */

use Nette\Application\Routers\CliRouter,
	Nette\Http\Request;



require __DIR__ . '/../bootstrap.php';



$_SERVER['argv'] = 1;
$httpRequest = new Request(new Nette\Http\UrlScript());

$router = new CliRouter;
Assert::null( $router->match($httpRequest) );
