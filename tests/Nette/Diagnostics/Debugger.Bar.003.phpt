<?php

/**
 * Test: Nette\Diagnostics\Debugger Bar in production mode.
 *
 * @author     David Grudl
 * @package    Nette
 * @subpackage UnitTests
 */

use Nette\Diagnostics\Debugger;



require __DIR__ . '/../bootstrap.php';



Debugger::$consoleMode = FALSE;
Debugger::$productionMode = TRUE;
header('Content-Type: text/html');

Debugger::enable();

function shutdown() {
	Assert::same('', ob_get_clean());
}
Assert::handler('shutdown');
