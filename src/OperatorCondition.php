<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle;

use HelloFresh\FeatureToggle\Operator\OperatorInterface;

/**
 * A condition based on the name of the value from the context and an operator.
 */
class OperatorCondition implements ConditionInterface
{
    /** @var string */
    private $key;

    /** @var OperatorInterface */
    private $operator;

    /**
     * @param string $key Name of the value
     * @param OperatorInterface $operator Operator to run
     */
    public function __construct($key, OperatorInterface $operator)
    {
        $this->key = $key;
        $this->operator = $operator;
    }

    /**
     * {@inheritdoc}
     */
    public function holdsFor(Context $context)
    {
        if (!$context->containsKey($this->key)) {
            return false;
        }
        $argument = $context->get($this->key);

        return $this->operator->appliesTo($argument);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return OperatorInterface
     */
    public function getOperator()
    {
        return $this->operator;
    }
}