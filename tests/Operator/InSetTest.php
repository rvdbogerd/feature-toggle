<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Operator;

use Collections\ArrayList;
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
        return [
            [5, new ArrayList([1, 1, 2, 3, 5, 8])],
            ['foo', new ArrayList(['foo', 'bar'])],
        ];
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
        return [
            [5, new ArrayList([1, 1, 2, 3])],
            ['foo', new ArrayList(['qux', 'bar'])],
        ];
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
        return [
            [null, new ArrayList([null, 1])],
            [null, new ArrayList([0, 1])],
        ];
    }

    /**
     * @test
     */
    public function itExposesItsValues()
    {
        $values = new ArrayList([1, 'foo']);
        $operator = new InSet($values);

        $this->assertEquals($values, $operator->getValues());
    }
}
