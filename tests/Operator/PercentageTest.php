<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Operator;

use HelloFresh\FeatureToggle\Operator\Percentage;

class PercentageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider valuesInPercentage
     */
    public function itAppliesIfValueInPercentage($percentage, $argument)
    {
        $operator = new Percentage($percentage);
        $this->assertTrue($operator->appliesTo($argument));
    }

    public function valuesInPercentage()
    {
        return array(
            array(5, 4),
            array(5, 104),
            array(5, 1004),
            array(5, 1000),
            array(5, 1001),
        );
    }

    /**
     * @test
     * @dataProvider valuesNotInPercentage
     */
    public function itDoesNotApplyIfValueNotInPercentage($percentage, $argument)
    {
        $operator = new Percentage($percentage);
        $this->assertFalse($operator->appliesTo($argument));
    }

    public function valuesNotInPercentage()
    {
        return array(
            array(5, 5),
            array(5, 6),
            array(5, 106),
            array(5, 1006),
        );
    }

    /**
     * @test
     * @dataProvider valuesInPercentageShifted
     */
    public function itAppliesIfValueInShiftedPercentage($percentage, $argument)
    {
        $operator = new Percentage($percentage, 42);
        $this->assertTrue($operator->appliesTo($argument));
    }

    public function valuesInPercentageShifted()
    {
        return array(
            array(5, 46),
            array(5, 146),
            array(5, 1046),
            array(5, 1046),
            array(5, 1046),
        );
    }

    /**
     * @test
     * @dataProvider valuesNotInPercentageShifted
     */
    public function itDoesNotApplyIfValueInShiftedPercentage($percentage, $argument)
    {
        $operator = new Percentage($percentage, 42);
        $this->assertFalse($operator->appliesTo($argument));
    }

    public function valuesNotInPercentageShifted()
    {
        return array(
            array(5, 47),
            array(5, 48),
            array(5, 148),
            array(5, 1048),
        );
    }

    /**
     * @test
     */
    public function itExposesItsPercentageAndShift()
    {
        $operator = new Percentage(42, 5);

        $this->assertEquals(42, $operator->getPercentage());
        $this->assertEquals(5, $operator->getShift());
    }
}
