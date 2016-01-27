<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle\Operator;

/**
 * Operator calculates whether it applies to an argument or not.
 */
interface OperatorInterface
{
    /**
     * @param mixed $argument
     *
     * @return boolean True, if the operator applies to the argument
     */
    public function appliesTo($argument);
}
