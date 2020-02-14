<?php

namespace TorneLIB;

/**
 * Class Flags
 * @package TorneLIB
 * @version 6.0.0
 */
abstract class Flags
{
	private static $internalFlags;

	/**
	 * Set internal flag parameter.
	 *
	 * @param string $flagKey
	 * @param string $flagValue Nullable since 6.0.10 = If null, then it is considered a true boolean, set
	 *     setFlag("key") will always be true as an activation key
	 *
	 * @return bool If successful
	 * @throws \Exception
	 * @since 6.0.0
	 */
	public static function setFlag($flagKey = '', $flagValue = null)
	{
		if (!empty($flagKey)) {
			if (is_null($flagValue)) {
				$flagValue = true;
			}
			self::$internalFlags[$flagKey] = $flagValue;

			return true;
		}

		// LIB_UNHANDLED
		throw new \Exception(
			"Flags can not be empty",
			65535
		);
	}

	/**
	 * Get internal flag
	 *
	 * @param string $flagKey
	 *
	 * @return mixed|null
	 * @since 6.0.0
	 */
	public static function getFlag($flagKey = '')
	{
		if (isset(self::$internalFlags[$flagKey])) {
			return self::$internalFlags[$flagKey];
		}

		return null;
	}


	/// Flag sanities

	/**
	 * Check if flag is set and true
	 *
	 * @param string $flagKey
	 *
	 * @return bool
	 * @since 6.0.0
	 */
	public static function isFlag($flagKey = '')
	{
		if (self::hasFlag($flagKey)) {
			return (self::getFlag($flagKey) === 1 || self::getFlag($flagKey) === true ? true : false);
		}

		return false;
	}

	/**
	 * Check if there is an internal flag set with current key
	 *
	 * @param string $flagKey
	 *
	 * @return bool
	 * @since 6.0.0
	 */
	public static function hasFlag($flagKey = '')
	{
		if (!is_null(self::getFlag($flagKey))) {
			return true;
		}

		return false;
	}


	/// Cleanup Start

	/**
	 * @param string $flagKey
	 *
	 * @return bool
	 * @since 6.0.0
	 */
	public static function unsetFlag($flagKey = '')
	{
		if (self::hasFlag($flagKey)) {
			unset(self::$internalFlags[$flagKey]);

			return true;
		}

		return false;
	}

	/**
	 * @param string $flagKey
	 *
	 * @return bool
	 * @since 6.0.0
	 */
	public static function removeFlag($flagKey = '')
	{
		return self::unsetFlag($flagKey);
	}

	/**
	 * @param string $flagKey
	 *
	 * @return bool
	 * @since 6.0.0
	 */
	public static function deleteFlag($flagKey = '')
	{
		return self::unsetFlag($flagKey);
	}

	/**
	 * @since 6.0.0
	 */
	public static function clearAllFlags()
	{
		self::$internalFlags = [];
	}

	public static function getAllFlags()
	{
		return self::$internalFlags;
	}

}
