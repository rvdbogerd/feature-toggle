<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Operator;

use HelloFresh\FeatureToggle\Operator\GreaterThan;

class GreaterThanOperatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider greaterValues
     */
    public function itAppliesToGreaterValues($value, $argument)
    {
        $operator = new GreaterThan($value);
        $this->assertTrue($operator->appliesTo($argument));
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
    public function itDoesNotApplyToEqualValues($value, $argument)
    {
        $operator = new GreaterThan($value);
        $this->assertFalse($operator->appliesTo($argument));
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
    public function itDoesNotApplyToSmallerValues($value, $argument)
    {
        $operator = new GreaterThan($value);
        $this->assertFalse($operator->appliesTo($argument));
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
        $operator = new GreaterThan(42);
        $this->assertEquals(42, $operator->getValue());
    }
}
