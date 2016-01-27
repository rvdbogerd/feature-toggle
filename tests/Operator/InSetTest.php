<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Operator;

use HelloFresh\FeatureToggle\Operator\InSet;

class InSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider valuesInSet
     */
    public function itAppliesIfValueInSet($argument, $values)
    {
        $operator = new InSet($values);
        $this->assertTrue($operator->appliesTo($argument));
    }

    public function valuesInSet()
    {
        return array(
            array(5, array(1, 1, 2, 3, 5, 8)),
            array('foo', array('foo', 'bar')),
        );
    }

    /**
     * @test
     * @dataProvider valuesNotInSet
     */
    public function itDoesNotApplyIfValueNotInSet($argument, $set)
    {
        $operator = new InSet($set);
        $this->assertFalse($operator->appliesTo($argument));
    }

    public function valuesNotInSet()
    {
        return array(
            array(5, array(1, 1, 2, 3)),
            array('foo', array('qux', 'bar')),
        );
    }

    /**
     * @test
     * @dataProvider nullSets
     */
    public function itNeverAcceptNullAsPartOfASet($argument, $set)
    {
        $operator = new InSet($set);
        $this->assertFalse($operator->appliesTo($argument));
    }

    public function nullSets()
    {
        return array(
            array(null, array(null, 1)),
            array(null, array(0, 1)),
        );
    }

    /**
     * @test
     */
    public function itExposesItsValues()
    {
        $values = array(1, 'foo');
        $operator = new InSet($values);

        $this->assertEquals($values, $operator->getValues());
    }
}
