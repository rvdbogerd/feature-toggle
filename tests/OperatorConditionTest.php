<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle;

use HelloFresh\FeatureToggle\Context;
use HelloFresh\FeatureToggle\Operator\GreaterThan;
use HelloFresh\FeatureToggle\OperatorCondition;

class OperatorConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itReturnsFalseIfContextDoesNotContainKey()
    {
        $condition = new OperatorCondition('age', new GreaterThan(42));
        $context = new Context();

        $this->assertFalse($condition->holdsFor($context));
    }

    /**
     * @test
     * @dataProvider valueAvailable
     */
    public function itReturnsWhetherItOperatorHoldsForTheValueIfAvailable($value, $expected)
    {
        $condition = new OperatorCondition('age', new GreaterThan(42));
        $context = new Context();
        $context->set('age', $value);

        $this->assertEquals($expected, $condition->holdsFor($context));
    }

    public function valueAvailable()
    {
        return array(
            array(24, false),
            array(84, true),
        );
    }

    /**
     * @test
     */
    public function itExposesItsKeyAndOperator()
    {
        $key = 'age';
        $operator = new GreaterThan(42);
        $condition = new OperatorCondition($key, $operator);

        $this->assertEquals($key, $condition->getKey());
        $this->assertEquals($operator, $condition->getOperator());
    }
}
