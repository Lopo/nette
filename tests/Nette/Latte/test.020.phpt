<?php

/**
 * Test: Nette\Latte\Engine and macros test.
 *
 * @author     David Grudl
 * @package    Nette\Templates
 * @subpackage UnitTests
 * @keepTrailingSpaces
 */

use Nette\Templating\FileTemplate,
	Nette\Latte\Engine;



require __DIR__ . '/../bootstrap.php';

require __DIR__ . '/Template.inc';



// temporary directory
define('TEMP_DIR', __DIR__ . '/tmp');
TestHelpers::purge(TEMP_DIR);



$template = new FileTemplate;
$template->setCacheStorage(new MockCacheStorage(TEMP_DIR));
$template->registerFilter(new Engine);

Assert::match(file_get_contents(__DIR__ . '/test.020.expect'), $template->compile(file_get_contents(__DIR__ . '/templates/isLinkCurrent.latte')));
