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

Assert::match(<<<EOD
Block

EOD

, $template->render(<<<EOD
{block}
Block

EOD
));