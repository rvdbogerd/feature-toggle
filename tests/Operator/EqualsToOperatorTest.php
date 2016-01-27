<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Operator;

use HelloFresh\FeatureToggle\Operator\EqualsTo;

class EqualToOperatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider integerValues
     */
    public function itAppliesToIntegerValues($value, $argument)
    {
        $operator = new EqualsTo($value);
        $this->assertTrue($operator->appliesTo($argument));
    }

    public function integerValues()
    {
        return array(
            array(0, 0),
            array(42, 42),
            array(-42, -42),
        );
    }

    /**
     * @test
     * @dataProvider stringValues
     */
    public function itAppliesToStringValues($value, $argument)
    {
        $operator = new EqualsTo($value);
        $this->assertTrue($operator->appliesTo($argument));
    }

    public function stringValues()
    {
        return array(
            array("foo", "foo"),
            array('bar', 'bar'),
            array("baz", 'baz'),
        );
    }

    /**
     * @test
     * @dataProvider floatValues
     */
    public function itAppliesToFloatValues($value, $argument)
    {
        $operator = new EqualsTo($value);
        $this->assertTrue($operator->appliesTo($argument));
    }

    public function floatValues()
    {
        return array(
            array(3.14, 3.14),
            array(-3.14, -3.14),
        );
    }

    /**
     * @test
     * @dataProvider notEqualValues
     */
    public function itDoesNotApplyToNotEqualValues($value, $argument)
    {
        $operator = new EqualsTo($value);
        $this->assertFalse($operator->appliesTo($argument));
    }

    public function notEqualValues()
    {
        return array(
            array(42, 43),
            array(-42, -43),
            array(-42.1, -43.1),
            array(false, 0),
            array(null, 0),
            array(true, 1),
            array("0", 0),
        );
    }

    /**
     * @test
     */
    public function itExposesItsValue()
    {
        $operator = new EqualsTo(42);
        $this->assertEquals(42, $operator->getValue());
    }
}
