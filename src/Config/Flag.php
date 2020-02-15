<?php

namespace TorneLIB\Config;

use TorneLIB\Flags;

class Flag {
	public function __call($name, $arguments)
	{
		return call_user_func_array(sprintf('TorneLIB\Flags::%s', $name), $arguments);
	}
}
