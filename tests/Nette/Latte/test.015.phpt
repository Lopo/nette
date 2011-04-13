<?php

/**
 * Test: Nette\Latte\Engine and macros test.
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
	$template->render('Block{/block}');
	Assert::fail('Expected exception');
} catch (Exception $e) {
	Assert::exception('Nette\Latte\ParseException', 'Unexpected macro {/block}', $e );
}
