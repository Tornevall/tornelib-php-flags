<?php

namespace TorneLIB;

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
    public function getFlag($flagKey = '')
    {
        if (isset($this->internalFlags[$flagKey])) {
            return $this->internalFlags[$flagKey];
        }

        return null;
    }

}