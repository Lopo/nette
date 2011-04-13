<?php

/**
 * Test: Nette\Latte\Engine and invalid UTF-8.
 *
 * @author     David Grudl
 * @package    Nette\Templates
 * @subpackage UnitTests
 */

use Nette\Latte\Engine;



require __DIR__ . '/../bootstrap.php';

require __DIR__ . '/Template.inc';



$template = new MockTemplate;
$template->registerFilter(new Engine);


try {
	$template->render("\xAA");
	Assert::fail('Expected exception');
} catch (Exception $e) {
	Assert::exception('Nette\Latte\ParseException', '%a% UTF-8 %a%', $e );
}
