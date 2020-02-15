<?php

namespace TorneLIB\Config;

/**
 * Class Flag Non static caller.
 *
 * @package TorneLIB\Config
 * @version 6.1.0
 */
class Flag {
	public function __call($name, $arguments)
	{
		return call_user_func_array(sprintf('TorneLIB\Flags::%s', $name), $arguments);
	}
}
