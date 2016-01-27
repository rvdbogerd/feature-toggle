<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle\Operator;

class MatchesRegex extends EqualityOperator
{
    /**
     * {@inheritDoc}
     */
    public function appliesTo($argument)
    {
        return (bool)preg_match($this->value, $argument);
    }
}
