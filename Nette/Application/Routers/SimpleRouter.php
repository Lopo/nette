<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 *
 * Copyright (c) 2004, 2011 David Grudl (http://davidgrudl.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace Nette\Application\Routers;

use Nette;



/**
 * The bidirectional route for trivial routing via query parameters.
 *
 * @author     David Grudl
 */
class SimpleRouter extends Nette\Object implements Nette\Application\IRouter
{
	const PRESENTER_KEY = 'presenter';
	const MODULE_KEY = 'module';

	/** @var string */
	private $module = '';

	/** @var array */
	private $defaults;

	/** @var int */
	private $flags;



	/**
	 * @param  array   default values
	 * @param  int     flags
	 */
	public function __construct($defaults = array(), $flags = 0)
	{
		if (is_string($defaults)) {
			$a = strrpos($defaults, ':');
			if (!$a) {
				throw new \InvalidArgumentException("Argument must be array or string in format Presenter:action, '$defaults' given.");
			}
			$defaults = array(
				self::PRESENTER_KEY => substr($defaults, 0, $a),
				'action' => $a === strlen($defaults) - 1 ? Nette\Application\UI\Presenter::DEFAULT_ACTION : substr($defaults, $a + 1),
			);
		}

		if (isset($defaults[self::MODULE_KEY])) {
			$this->module = $defaults[self::MODULE_KEY] . ':';
			unset($defaults[self::MODULE_KEY]);
		}

		$this->defaults = $defaults;
		$this->flags = $flags;
	}



	/**
	 * Maps HTTP request to a PresenterRequest object.
	 * @param  Nette\Http\IRequest
	 * @return Nette\Application\Request|NULL
	 */
	public function match(Nette\Http\IRequest $httpRequest)
	{
		if ($httpRequest->getUri()->getPathInfo() !== '') {
			return NULL;
		}
		// combine with precedence: get, (post,) defaults
		$params = $httpRequest->getQuery();
		$params += $this->defaults;

		if (!isset($params[self::PRESENTER_KEY])) {
			throw new Nette\InvalidStateException('Missing presenter.');
		}

		$presenter = $this->module . $params[self::PRESENTER_KEY];
		unset($params[self::PRESENTER_KEY]);

		return new Nette\Application\Request(
			$presenter,
			$httpRequest->getMethod(),
			$params,
			$httpRequest->getPost(),
			$httpRequest->getFiles(),
			array(Nette\Application\Request::SECURED => $httpRequest->isSecured())
		);
	}



	/**
	 * Constructs absolute URL from PresenterRequest object.
	 * @param  Nette\Application\Request
	 * @param  Nette\Http\Url
	 * @return string|NULL
	 */
	public function constructUrl(Nette\Application\Request $appRequest, Nette\Http\Url $refUri)
	{
		$params = $appRequest->getParams();

		// presenter name
		$presenter = $appRequest->getPresenterName();
		if (strncasecmp($presenter, $this->module, strlen($this->module)) === 0) {
			$params[self::PRESENTER_KEY] = substr($presenter, strlen($this->module));
		} else {
			return NULL;
		}

		// remove default values; NULL values are retain
		foreach ($this->defaults as $key => $value) {
			if (isset($params[$key]) && $params[$key] == $value) { // intentionally ==
				unset($params[$key]);
			}
		}

		$uri = ($this->flags & self::SECURED ? 'https://' : 'http://') . $refUri->getAuthority() . $refUri->getPath();
		$sep = ini_get('arg_separator.input');
		$query = http_build_query($params, '', $sep ? $sep[0] : '&');
		if ($query != '') { // intentionally ==
			$uri .= '?' . $query;
		}
		return $uri;
	}



	/**
	 * Returns default values.
	 * @return array
	 */
	public function getDefaults()
	{
		return $this->defaults;
	}

}