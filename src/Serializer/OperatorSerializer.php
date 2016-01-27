<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle\Serializer;

use Collections\MapInterface;
use HelloFresh\FeatureToggle\Operator\EqualsTo;
use HelloFresh\FeatureToggle\Operator\GreaterThan;
use HelloFresh\FeatureToggle\Operator\GreaterThanEqual;
use HelloFresh\FeatureToggle\Operator\InSet;
use HelloFresh\FeatureToggle\Operator\LessThan;
use HelloFresh\FeatureToggle\Operator\LessThanEqual;
use HelloFresh\FeatureToggle\Operator\MatchesRegex;
use HelloFresh\FeatureToggle\Operator\OperatorInterface;
use HelloFresh\FeatureToggle\Operator\Percentage;

/**
 * Hand written serializer to serialize an Operator to a php array.
 */
class OperatorSerializer
{
    /**
     * @param OperatorInterface $operator
     *
     * @return string
     */
    public function serialize(OperatorInterface $operator)
    {
        switch (true) {
            case $operator instanceof EqualsTo:
                return ['name' => 'equals-to', 'value' => $operator->getValue()];
            case $operator instanceof GreaterThan:
                return ['name' => 'greater-than', 'value' => $operator->getValue()];
            case $operator instanceof GreaterThanEqual:
                return ['name' => 'greater-than-equal', 'value' => $operator->getValue()];
            case $operator instanceof InSet:
                return ['name' => 'in-set', 'values' => $operator->getValues()];
            case $operator instanceof LessThan:
                return ['name' => 'less-than', 'value' => $operator->getValue()];
            case $operator instanceof LessThanEqual:
                return ['name' => 'less-than-equal', 'value' => $operator->getValue()];
            case $operator instanceof Percentage:
                return [
                    'name' => 'percentage',
                    'percentage' => $operator->getPercentage(),
                    'shift' => $operator->getShift()
                ];
            case $operator instanceof MatchesRegex:
                return ['name' => 'matches-regex', 'value' => $operator->getValue()];
            default:
                throw new \RuntimeException(sprintf('Unknown operator %s.', get_class($operator)));
        }
    }

    /**
     * @param MapInterface $operator
     *
     * @return OperatorInterface
     */
    public function deserialize(MapInterface $operator)
    {
        switch ($operator->get('name')) {
            case 'equals-to':
                return new EqualsTo($operator->get('value'));
            case 'greater-than':
                return new GreaterThan($operator->get('value'));
            case 'greater-than-equal':
                return new GreaterThanEqual($operator->get('value'));
            case 'in-set':
                return new InSet($operator->get('values'));
            case 'less-than':
                return new LessThan($operator->get('value'));
            case 'less-than-equal':
                return new LessThanEqual($operator->get('value'));
            case 'percentage':
                return new Percentage($operator->get('percentage'), $operator->get('shift'));
            case 'matches-regex':
                return new MatchesRegex($operator->get('value'));
            default:
                throw new \RuntimeException(sprintf('Unknown operator with name "%s".', $operator->get('name')));
        }
    }
}
