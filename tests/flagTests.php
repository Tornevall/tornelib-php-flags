<?php

namespace TorneLIB;

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
	die();
}

require_once(__DIR__ . '/../vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use TorneLIB\Config\Flag;

class flagTests extends TestCase
{
	/**
	 * @test
	 * @throws \Exception
	 */
	public function setFlagKey()
	{
		$flagStatus = Flags::setFlag('firstFlag', 'present');
		static::assertTrue(
			(
			$flagStatus ? true : false &&
				Flags::getFlag('firstFlag') === 'present'
			)
		);
	}

	/**
	 * @test
	 */
	public function setTrueFlag()
	{
		Flags::setFlag('secondFlag', true);
		static::assertTrue(Flags::getFlag('secondFlag'));
	}

	/**
	 * @test
	 */
	public function setTrueWithoutKey()
	{
		Flags::setFlag('thirdFlag');
		static::assertTrue(Flags::isFlag('thirdFlag'));
	}

	public function hasFlags()
	{
		Flags::setFlag('existingFlag', 'yes');

		static::assertTrue(
			Flags::hasFlag('existingFlag') === 'yes' &&
			!Flags::hasFlag('unExistingFlag')
		);
	}

	/**
	 * @test
	 */
	public function getAll()
	{
		Flags::setFlag('firstFlag', 'present');
		Flags::setFlag('secondFlag', true);
		Flags::setFlag('thirdFlag');

		static::assertCount(3, Flags::getAllFlags());
	}

	/**
	 * @test
	 */
	public function clearAll()
	{
		Flags::setFlag('firstFlag', 'present');
		Flags::setFlag('secondFlag', true);
		Flags::setFlag('thirdFlag');
		Flags::clearAllFlags();

		static::assertCount(0, Flags::getAllFlags());
	}

	/**
	 * @test
	 */
	public function clearOne()
	{
		Flags::setFlag('firstFlag', 'present');
		Flags::setFlag('secondFlag', true);
		Flags::setFlag('thirdFlag');
		Flags::removeFlag('secondFlag');

		static::assertCount(2, Flags::getAllFlags());
	}

	/**
	 * @test
	 * @testdox Using the non static class (which actually calls for the static one).
	 * @throws \Exception
	 */
	public function setNonStaticFlagKey()
	{
		$flag = new Flag();
		$flagStatus = $flag->setFlag('firstFlag', 'present');
		static::assertTrue(
			(
			$flagStatus ? true : false &&
				$flag->getFlag('firstFlag') === 'present'
			)
		);
	}

}
