<?php

/**
 * Copyright © Tomas Tornevall / Tornevall Networks. All rights reserved.
 * See LICENSE for license details.
 */

namespace TorneLIB;

use TorneLIB\Exception\Constants;
use TorneLIB\Exception\ExceptionHandler;

/**
 * Class Flags Statically callable.
 * @package TorneLIB
 * @version 6.1.4
 */
class Flags
{
    /**
     * @var array Internally stored flags.
     */
    private $internalFlags = [];

    /**
     * List of locked flags, which can only be set while they are not set.
     * @var array
     * @since 6.1.4
     */
    private $lockedFlags = [];

    /**
     * @var array For all static calls.
     */
    protected static $staticFlagSet = [];

    /**
     * Set internal flag parameter.
     *
     * @param string $flagKey
     * @param null $flagValue
     * @param bool $lock
     * @return bool If successful
     * @since 6.1.0
     */
    public function setFlag($flagKey = '', $flagValue = null, $lock = false)
    {
        $return = true;
        if (!empty($flagKey)) {
            if (is_null($flagValue)) {
                $flagValue = true;
            }
            if ($lock) {
                $this->lockedFlags[$flagKey] = (bool)$lock;
            }
            if (isset($this->lockedFlags[$flagKey]) &&
                $this->lockedFlags[$flagKey] === true &&
                isset($this->internalFlags[$flagKey])
            ) {
                $return = false;
            } else {
                $this->internalFlags[$flagKey] = $flagValue;
            }

            return $return;
        }

        // LIB_UNHANDLED
        throw new ExceptionHandler(
            sprintf(
                'Exception in "%s": Flags can not be empty.',
                __FUNCTION__
            ),
            Constants::LIB_FLAG_EXCEPTION
        );
    }

    /**
     * Get internal flag
     *
     * @param string $flagKey
     * @return mixed|null
     * @since 6.1.0
     */
    public function getFlag($flagKey = '')
    {
        if (isset($this->internalFlags[$flagKey])) {
            return $this->internalFlags[$flagKey];
        }

        return null;
    }

    /**
     * Check if flag is set and true
     *
     * @param string $flagKey
     * @return bool
     * @since 6.1.0
     */
    public function isFlag($flagKey = '')
    {
        if ($this->hasFlag($flagKey)) {
            return ($this->getFlag($flagKey) === 1 || $this->getFlag($flagKey) === true ? true : false);
        }

        return false;
    }

    /**
     * Check if there is an internal flag set with current key
     *
     * @param string $flagKey
     * @return bool
     * @since 6.1.0
     */
    public function hasFlag($flagKey = '')
    {
        if (!is_null($this->getFlag($flagKey))) {
            return true;
        }

        return false;
    }

    /**
     * @param array $arrayData
     * @return bool
     * @since 6.1.1
     */
    public function isAssoc(array $arrayData)
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
     * @throws ExceptionHandler
     * @since 6.1.1
     */
    public function setFlags($flags = [], $lock = [])
    {
        if ($this->isAssoc($flags)) {
            foreach ($flags as $flagKey => $flagData) {
                $lockFlag = isset($lock[$flagKey]) ? $lock[$flagKey] : false;
                $this->setFlag($flagKey, $flagData, $lockFlag);
            }
        } else {
            foreach ($flags as $flagKey) {
                $lockFlag = isset($lock[$flagKey]) ? $lock[$flagKey] : false;
                $this->setFlag($flagKey, true, $lockFlag);
            }
        }
    }

    /**
     * Return all flags
     * @return array
     * @since 6.1.1
     */
    public function getFlags()
    {
        return $this->internalFlags;
    }

    /**
     * @param string $flagKey
     * @return bool
     * @since 6.1.0
     */
    public function unsetFlag($flagKey = '')
    {
        if ($this->hasFlag($flagKey)) {
            unset($this->internalFlags[$flagKey]);

            return true;
        }

        return false;
    }

    /**
     * @param string $flagKey
     * @return bool
     * @since 6.1.0
     */
    public function removeFlag($flagKey = '')
    {
        return $this->unsetFlag($flagKey);
    }

    /**
     * @param string $flagKey
     * @return bool
     * @since 6.1.0
     */
    public function deleteFlag($flagKey = '')
    {
        return $this->unsetFlag($flagKey);
    }

    /**
     * @since 6.1.0
     */
    public function clearAllFlags()
    {
        $this->internalFlags = [];
    }

    /**
     * Get them all.
     * @return mixed
     * @since 6.1.1
     */
    public function getAllFlags()
    {
        return $this->internalFlags;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @since 6.1.2
     */
    public static function __callStatic($name, $arguments)
    {
        if (!is_object(self::$staticFlagSet)) {
            self::$staticFlagSet = new Flags();
        }

        return call_user_func_array(
            [
                self::$staticFlagSet,
                preg_replace(
                    '/^_/',
                    '',
                    $name
                ),
            ],
            $arguments
        );
    }
}
