<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle\Operator;

class Percentage implements OperatorInterface
{
    private $percentage;
    private $shift;

    public function __construct($percentage, $shift = 0)
    {
        $this->percentage = $percentage;
        $this->shift = $shift;
    }

    /**
     * {@inheritdoc}
     */
    public function appliesTo($argument)
    {
        $asPercentage = $argument % 100;

        return $asPercentage >= $this->shift &&
        $asPercentage < ($this->percentage + $this->shift);
    }

    public function getPercentage()
    {
        return $this->percentage;
    }

    public function getShift()
    {
        return $this->shift;
    }
}
