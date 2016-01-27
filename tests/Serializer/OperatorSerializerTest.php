<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Serializer;

use Collections\ArrayList;
use Collections\Dictionary;
use HelloFresh\FeatureToggle\Operator\GreaterThan;
use HelloFresh\FeatureToggle\Operator\GreaterThanEqual;
use HelloFresh\FeatureToggle\Operator\InSet;
use HelloFresh\FeatureToggle\Operator\LessThan;
use HelloFresh\FeatureToggle\Operator\LessThanEqual;
use HelloFresh\FeatureToggle\Operator\Percentage;
use HelloFresh\FeatureToggle\Serializer\OperatorSerializer;

class OperatorSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Unknown operator Tests\HelloFresh\FeatureToggle\Serializer\UnknownOperator.
     */
    public function itThrowsExceptionOnUnknownOperator()
    {
        $serializer = new OperatorSerializer();

        $serializer->serialize(new UnknownOperator());
    }

    /**
     * @test
     * @dataProvider knownOperators
     */
    public function itSerializesKnownOperators($operator, $expected)
    {
        $serializer = new OperatorSerializer();

        $data = $serializer->serialize($operator);
        $this->assertEquals($expected, $data);
    }

    public function knownOperators()
    {
        return [
            [new GreaterThan(42), ['name' => 'greater-than', 'value' => 42]],
            [new GreaterThanEqual(42), ['name' => 'greater-than-equal', 'value' => 42]],
            [new LessThan(42), ['name' => 'less-than', 'value' => 42]],
            [new LessThanEqual(42), ['name' => 'less-than-equal', 'value' => 42]],
            [new Percentage(42, 5), ['name' => 'percentage', 'percentage' => 42, 'shift' => 5]],
            [new InSet(new ArrayList([1, 2, 3])), ['name' => 'in-set', 'values' => new ArrayList([1, 2, 3])]],
        ];
    }

    /**
     * @test
     * @dataProvider knownOperators
     */
    public function itDeserializesKnownOperators($expected, $serialized)
    {
        $serializer = new OperatorSerializer();

        $operator = $serializer->deserialize(new Dictionary($serialized));
        $this->assertEquals($expected, $operator);
    }

    /**
     * @test
     * @dataProvider missingKeys
     * @expectedException \RuntimeException
     */
    public function itThrowsAnExceptionIfAKeyIsMissingFromTheData($serialized)
    {
        $serializer = new OperatorSerializer();

        $operator = $serializer->deserialize($serialized);
    }

    public function missingKeys()
    {
        return [
            [new Dictionary([])],
            [new Dictionary(['name' => 'greater-than'])],
            [new Dictionary(['name' => 'greater-than-equal'])],
            [new Dictionary(['name' => 'less-than'])],
            [new Dictionary(['name' => 'less-than-equal'])],
            [new Dictionary(['name' => 'percentage'])],
            [new Dictionary(['name' => 'percentage', 'percentage' => 42])],
            [new Dictionary(['name' => 'percentage', 'shift' => 5])],
            [new Dictionary(['name' => 'in-set'])],
        ];
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function itThrowsAnExceptionOnDeserializingUnknownOperator()
    {
        $serializer = new OperatorSerializer();

        $operator = $serializer->deserialize(new Dictionary(['name' => 'unknown']));
    }
}
