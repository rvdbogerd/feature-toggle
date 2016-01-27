<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle\Operator;

use Collections\VectorInterface;

/**
 * Operator that compare the given argument on equality based on a value.
 */
class InSet implements OperatorInterface
{
    private $values;

    /**
     * @param VectorInterface $values
     */
    public function __construct(VectorInterface $values)
    {
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function appliesTo($argument)
    {
        return null !== $argument
        && in_array($argument, $this->values->toArray());
    }

    /**
     * @return VectorInterface
     */
    public function getValues()
    {
        return $this->values;
    }
}
