<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle\Operator;

class EqualsTo extends EqualityOperator
{
    /**
     * {@inheritdoc}
     */
    public function appliesTo($argument)
    {
        return $argument === $this->value;
    }
}
