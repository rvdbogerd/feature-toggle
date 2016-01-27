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
use HelloFresh\FeatureToggle\OperatorCondition;

/**
 * Hand written serializer to serialize an OperatorCondition to a php array.
 */
class OperatorConditionSerializer
{
    private $operatorSerializer;

    /**
     * @param OperatorSerializer $operatorSerializer
     */
    public function __construct(OperatorSerializer $operatorSerializer)
    {
        $this->operatorSerializer = $operatorSerializer;
    }

    /**
     * @param OperatorCondition $condition
     *
     * @return string
     */
    public function serialize(OperatorCondition $condition)
    {
        return array(
            'name' => 'operator-condition',
            'key' => $condition->getKey(),
            'operator' => $this->operatorSerializer->serialize($condition->getOperator()),
        );
    }

    /**
     * @param MapInterface $condition
     *
     * @return OperatorCondition
     */
    public function deserialize(MapInterface $condition)
    {
        $name = $condition->get('name');

        if ($name !== 'operator-condition') {
            throw new \RuntimeException(sprintf('Unable to deserialize operator with name "%s".', $name));
        }
        $operator = $this->operatorSerializer->deserialize($condition->get('operator'));

        return new OperatorCondition($condition->get('key'), $operator);
    }
}
