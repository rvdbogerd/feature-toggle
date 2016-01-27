<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle;

/**
 * Feature class.
 */
class Feature implements FeatureInterface
{
    /** @var string */
    protected $name;

    /** @var Toggle */
    protected $toggle;

    /**
     * Feature constructor.
     * @param $name - The name of the feature
     * @param Toggle $toggle - Is it enabled or not?
     */
    public function __construct($name, Toggle $toggle)
    {
        $this->name = $name;
        $this->toggle = $toggle;
    }

    /**
     * @inheritdoc
     */
    public function isEnabled()
    {
        return $this->toggle->isOn();
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }
}
