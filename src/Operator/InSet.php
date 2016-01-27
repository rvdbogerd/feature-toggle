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
class InSet implements OperatorInterface
{
    private $values;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function appliesTo($argument)
    {
        return null !== $argument
        && in_array($argument, $this->values);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }
}
