<?php

namespace TorneLIB;

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
	die();
}

require_once(__DIR__ . '/../vendor/autoload.php');

use PHPUnit\Framework\TestCase;


class flagTests extends TestCase
{
	/**
	 * @test
	 * @throws \Exception
	 */
	public function setFlagKey()
	{
		$flagStatus = Flags::setFlag('firstFlag', 'present');
		static::assertTrue((
		$flagStatus ? true : false &&
			Flags::getFlag('firstFlag') === 'present'
		));
	}

	/**
	 * @test
	 */
	public function setTrueFlag() {
		Flags::setFlag('secondFlag', true);
		static::assertTrue(Flags::getFlag('secondFlag'));
	}

	/**
	 * @test
	 */
	public function setTrueWitoutKey() {
		Flags::setFlag('thirdFlag');
		static::assertTrue(Flags::isFlag('thirdFlag'));
	}

	/**
	 * @test
	 */
	public function getAll() {
		Flags::setFlag('firstFlag', 'present');
		Flags::setFlag('secondFlag', true);
		Flags::setFlag('thirdFlag');

		static::assertCount(3, Flags::getAllFlags());
	}
}
