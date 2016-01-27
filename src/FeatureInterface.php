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
 * Represents a feature that can be toggle on or off
 */
interface FeatureInterface
{
    /**
     * Is the feature enabled?
     * @return bool
     */
    public function isEnabled();

    /**
     * Gets the name of the feature
     * @return string
     */
    public function getName();
}
