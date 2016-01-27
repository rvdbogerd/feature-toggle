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
 * Operator that compare the given argument on equality based on a value.
 */
abstract class EqualityOperator implements OperatorInterface
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed The value compared to
     */
    public function getValue()
    {
        return $this->value;
    }
}
