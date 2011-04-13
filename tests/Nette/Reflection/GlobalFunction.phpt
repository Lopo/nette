<?php

/**
 * Test: FunctionReflection tests.
 *
 * @author     David Grudl
 * @package    Nette\Reflection
 * @subpackage UnitTests
 */

use Nette\Reflection\GlobalFunction;



require __DIR__ . '/../bootstrap.php';



function bar() {}

$function = new GlobalFunction('bar');
Assert::null( $function->getExtension() );


$function = new GlobalFunction('sort');
Assert::equal( new Nette\Reflection\Extension('standard'), $function->getExtension() );
