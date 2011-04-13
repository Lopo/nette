<?php

/**
 * Test: PropertyReflection tests.
 *
 * @author     David Grudl
 * @package    Nette\Reflection
 * @subpackage UnitTests
 */

use Nette\Reflection\Property;



require __DIR__ . '/../bootstrap.php';



class A
{
	public $prop;
}

class B extends A
{
}

$propInfo = new Property('B', 'prop');
Assert::equal( new Nette\Reflection\ClassType('A'), $propInfo->getDeclaringClass() );
