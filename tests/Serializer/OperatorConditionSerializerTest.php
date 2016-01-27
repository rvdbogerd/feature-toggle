<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Serializer;

use Collections\Dictionary;
use HelloFresh\FeatureToggle\Operator\GreaterThan;
use HelloFresh\FeatureToggle\OperatorCondition;
use HelloFresh\FeatureToggle\Serializer\OperatorConditionSerializer;
use HelloFresh\FeatureToggle\Serializer\OperatorSerializer;

class OperatorConditionSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itSerializesAnOperator()
    {
        $serializer = $this->createOperatorConditionSerializer();

        $operator = new OperatorCondition('user_id', new GreaterThan(42));
        $data = $serializer->serialize($operator);

        $this->assertEquals(
            array(
                'name' => 'operator-condition',
                'key' => 'user_id',
                'operator' => array('name' => 'greater-than', 'value' => 42)
            ),
            $data
        );
    }

    /**
     * @test
     */
    public function itDeserializesAnOperator()
    {
        $serializer = $this->createOperatorConditionSerializer();

        $serialized = new Dictionary([
            'name' => 'operator-condition',
            'key' => 'user_id',
            'operator' => ['name' => 'greater-than', 'value' => 42]
        ]);

        $expected = new OperatorCondition('user_id', new GreaterThan(42));
        $this->assertEquals($expected, $serializer->deserialize($serialized));
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function itThrowsExceptionOnUnknownName()
    {
        $serializer = $this->createOperatorConditionSerializer();

        $serialized = new Dictionary([
            'name' => 'unknown-name',
            'key' => 'user_id',
            'operator' => ['name' => 'greater-than', 'value' => 42]
        ]);

        $serializer->deserialize($serialized);
    }

    /**
     * @test
     * @dataProvider missingKeys
     * @expectedException \RuntimeException
     */
    public function itThrowsExceptionOnMissingKey($serialized)
    {
        $serializer = $this->createOperatorConditionSerializer();

        $serializer->deserialize($serialized);
    }

    public function missingKeys()
    {
        return array(
            array(new Dictionary(array())),
            array(new Dictionary(array('name'))),
            array(new Dictionary(array('name', 'key'))),
            array(new Dictionary(array('name', 'operator'))),
        );
    }

    private function createOperatorConditionSerializer()
    {
        $operatorSerializer = new OperatorSerializer();

        return new OperatorConditionSerializer($operatorSerializer);
    }
}
