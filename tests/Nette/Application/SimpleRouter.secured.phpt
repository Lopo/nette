<?php

/**
 * Test: Nette\Application\Routers\SimpleRouter with secured connection.
 *
 * @author     David Grudl
 * @package    Nette\Application
 * @subpackage UnitTests
 */

use Nette\Application\Routers\SimpleRouter;



require __DIR__ . '/../bootstrap.php';



$router = new SimpleRouter(array(
	'id' => 12,
	'any' => 'anyvalue',
), SimpleRouter::SECURED);

$uri = new Nette\Http\UrlScript('http://nette.org/file.php');
$uri->setScriptPath('/file.php');
$uri->setQuery(array(
	'presenter' => 'myPresenter',
));
$httpRequest = new Nette\Http\Request($uri);

$req = new Nette\Application\Request(
	'othermodule:presenter',
	Nette\Http\Request::GET,
	array()
);

$url = $router->constructUrl($req, $httpRequest->uri);
Assert::same( 'https://nette.org/file.php?presenter=othermodule%3Apresenter',  $url );
