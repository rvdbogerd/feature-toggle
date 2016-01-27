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
 * Represents a condition that will be applied to a feature.
 * For instance if you want a feature that will be shown only
 * to users from US, you just need to set the condition.
 */
interface ConditionInterface
{
    /**
     * @param Context $context
     *
     * @return bool True, if the condition holds for the given context
     */
    public function holdsFor(Context $context);
}
