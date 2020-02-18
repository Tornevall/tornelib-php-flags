<?php

namespace TorneLIB;

/**
 * Class Flags Statically callable.
 * @package TorneLIB
 * @version 6.1.1
 */
abstract class Flags
{
    private static $internalFlags;

    /**
     * Set internal flag parameter.
     *
     * @param string $flagKey
     * @param string $flagValue
     *
     * @return bool If successful
     * @throws \Exception
     * @since 6.1.0
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
     * @since 6.1.0
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
     * @since 6.1.0
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
     * @since 6.1.0
     */
    public static function hasFlag($flagKey = '')
    {
        if (!is_null(self::getFlag($flagKey))) {
            return true;
        }

        return false;
    }

    /**
     * @param array $arrayData
     *
     * @return bool
     * @since 6.1.1
     */
    public static function isAssoc(array $arrayData)
    {
        if ([] === $arrayData) {
            return false;
        }

        return array_keys($arrayData) !== range(0, count($arrayData) - 1);
    }

    /**
     * Set multiple flags
     *
     * @param array $flags
     * @throws \Exception
     * @since 6.1.1
     */
    public static function setFlags($flags = [])
    {
        if (self::isAssoc($flags)) {
            foreach ($flags as $flagKey => $flagData) {
                self::setFlag($flagKey, $flagData);
            }
        } else {
            foreach ($flags as $flagKey) {
                self::setFlag($flagKey, true);
            }
        }
    }

    /**
     * Return all flags
     *
     * @return array
     * @since 6.1.1
     */
    public function getFlags()
    {
        return self::$internalFlags;
    }

    /// Cleanup Start

    /**
     * @param string $flagKey
     *
     * @return bool
     * @since 6.1.0
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
     * @since 6.1.0
     */
    public static function removeFlag($flagKey = '')
    {
        return self::unsetFlag($flagKey);
    }

    /**
     * @param string $flagKey
     *
     * @return bool
     * @since 6.1.0
     */
    public static function deleteFlag($flagKey = '')
    {
        return self::unsetFlag($flagKey);
    }

    /**
     * @since 6.1.0
     */
    public static function clearAllFlags()
    {
        self::$internalFlags = [];
    }

    /**
     * Get them all.
     * @return mixed
     */
    public static function getAllFlags()
    {
        return self::$internalFlags;
    }

}
