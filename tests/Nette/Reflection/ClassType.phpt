<?php

/**
 * Test: ClassReflection tests.
 *
 * @author     David Grudl
 * @package    Nette\Reflection
 * @subpackage UnitTests
 */

use Nette\Reflection\ClassType;



require __DIR__ . '/../bootstrap.php';



class Foo
{
	public function f() {}
}

class Bar extends Foo implements Countable
{
	public $var;

	function count() {}
}


Assert::equal( new ClassType('Bar'), ClassType::from('Bar') );
Assert::equal( new ClassType('Bar'), ClassType::from(new Bar) );



$rc = ClassType::from('Bar');

Assert::null( $rc->getExtension() );


Assert::equal( array(
	'Countable' => new ClassType('Countable'),
), $rc->getInterfaces() );


Assert::equal( new ClassType('Foo'), $rc->getParentClass() );


Assert::null( $rc->getConstructor() );


Assert::equal( new Nette\Reflection\Method('Foo', 'f'), $rc->getMethod('f') );


try {
	$rc->getMethod('doesntExist');
} catch (Exception $e) {
	Assert::same( 'Method Bar::doesntExist() does not exist', $e->getMessage() );

}

Assert::equal( array(
	new Nette\Reflection\Method('Bar', 'count'),
	new Nette\Reflection\Method('Foo', 'f'),
), $rc->getMethods() );



Assert::equal( new Nette\Reflection\Property('Bar', 'var'), $rc->getProperty('var') );


try {
	$rc->getProperty('doesntExist');
} catch (exception $e) {
	Assert::same( 'Property Bar::$doesntExist does not exist', $e->getMessage() );

}

Assert::equal( array(
	new Nette\Reflection\Property('Bar', 'var'),
), $rc->getProperties() );
