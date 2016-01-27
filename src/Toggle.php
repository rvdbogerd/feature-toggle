<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle;

final class Toggle
{
    /** @var  bool */
    private $value;

    /**
     * Toggle constructor.
     * @param bool $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public static function on()
    {
        return new Toggle(true);
    }

    public static function off()
    {
        return new Toggle(false);
    }

    public function isOn()
    {
        return $this->value === true;
    }

    public function isOff()
    {
        return $this->value === false;
    }
}