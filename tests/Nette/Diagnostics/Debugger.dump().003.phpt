<?php

/**
 * Test: Nette\Diagnostics\Debugger::dump() in production mode.
 *
 * @author     David Grudl
 * @package    Nette
 * @subpackage UnitTests
 */

use Nette\Diagnostics\Debugger;



require __DIR__ . '/../bootstrap.php';



Debugger::$consoleMode = FALSE;
Debugger::$productionMode = TRUE;


ob_start();
Debugger::dump('sensitive data');
Assert::same( '', ob_get_clean() );

Assert::match( '<pre class="nette-dump">"forced" (6)
</pre>', Debugger::dump('forced', TRUE) );
