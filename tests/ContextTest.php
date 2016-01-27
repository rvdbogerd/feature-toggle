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

class ContextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itSetsAValue()
    {
        $context = new Context();
        $context->set('foo', 'bar');

        $this->assertEquals('bar', $context->get('foo'));
    }

    /**
     * @test
     * @dataProvider validValues
     */
    public function itExposesWhetherItHasAValue($value)
    {
        $context = new Context();
        $context->set('foo', $value);

        $this->assertTrue($context->containsKey('foo'));
    }

    public function validValues()
    {
        return array(
            array(42),
            array('bar'),
            array(null),
            array(true),
            array(false),
            array(0.1),
        );
    }

    /**
     * @test
     */
    public function itDoesNotHaveAValueThatWasNeverSet()
    {
        $context = new Context();

        $this->assertFalse($context->containsKey('foo'));
    }
}