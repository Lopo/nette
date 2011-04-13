<?php

/**
 * Test: ExtensionReflection tests.
 *
 * @author     David Grudl
 * @package    Nette\Reflection
 * @subpackage UnitTests
 */

use Nette\Reflection\Extension;



require __DIR__ . '/../bootstrap.php';



$ext = new Extension('standard');
$funcs = $ext->getFunctions();
Assert::equal( new Nette\Reflection\GlobalFunction('sleep'), $funcs['sleep'] );



$ext = new Extension('reflection');
Assert::equal( array(
	'ReflectionException' => new Nette\Reflection\ClassType('ReflectionException'),
	'Reflection' => new Nette\Reflection\ClassType('Reflection'),
	'Reflector' => new Nette\Reflection\ClassType('Reflector'),
	'ReflectionFunctionAbstract' => new Nette\Reflection\ClassType('ReflectionFunctionAbstract'),
	'ReflectionFunction' => new Nette\Reflection\ClassType('ReflectionFunction'),
	'ReflectionParameter' => new Nette\Reflection\ClassType('ReflectionParameter'),
	'ReflectionMethod' => new Nette\Reflection\ClassType('ReflectionMethod'),
	'ReflectionClass' => new Nette\Reflection\ClassType('ReflectionClass'),
	'ReflectionObject' => new Nette\Reflection\ClassType('ReflectionObject'),
	'ReflectionProperty' => new Nette\Reflection\ClassType('ReflectionProperty'),
	'ReflectionExtension' => new Nette\Reflection\ClassType('ReflectionExtension'),
), $ext->getClasses() );
