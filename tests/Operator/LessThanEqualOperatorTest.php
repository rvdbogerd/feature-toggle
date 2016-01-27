<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Operator;

use HelloFresh\FeatureToggle\Operator\LessThanEqual;

class LessThanEqualOperatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider greaterValues
     */
    public function itDoesNotApplyToGreaterValues($value, $argument)
    {
        $operator = new LessThanEqual($value);
        $this->assertFalse($operator->appliesTo($argument));
    }

    public function greaterValues()
    {
        return array(
            array(42, 43),
            array(42, 1337),
            array(42, 42.1),
            array(0.1, 0.2),
        );
    }

    /**
     * @test
     * @dataProvider equalValues
     */
    public function itAppliesToEqualValues($value, $argument)
    {
        $operator = new LessThanEqual($value);
        $this->assertTrue($operator->appliesTo($argument));
    }

    public function equalValues()
    {
        return array(
            array(42, 42),
            array(42.1, 42.1),
            array(0.1, 0.1),
        );
    }

    /**
     * @test
     * @dataProvider smallerValues
     */
    public function itAppliesToSmallerValues($value, $argument)
    {
        $operator = new LessThanEqual($value);
        $this->assertTrue($operator->appliesTo($argument));
    }

    public function smallerValues()
    {
        return array(
            array(43, 42),
            array(1337, 42),
            array(42.1, 42),
            array(0.2, 0.1),
        );
    }

    /**
     * @test
     */
    public function itExposesItsValue()
    {
        $operator = new LessThanEqual(42);
        $this->assertEquals(42, $operator->getValue());
    }
}
