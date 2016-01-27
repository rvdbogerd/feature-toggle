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
use HelloFresh\FeatureToggle\ExpressionCondition;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionConditionTest extends \PHPUnit_Framework_TestCase
{
    protected $language;

    protected function setUp()
    {
        $this->language = new ExpressionLanguage();
    }

    /**
     * @test
     * @expectedException \Symfony\Component\ExpressionLanguage\SyntaxError
     */
    public function itShouldFireASyntaxErrorException()
    {
        $condition = new ExpressionCondition("price < 5", $this->language);
        $context = new Context();

        $condition->holdsFor($context);
    }

    /**
     * @test
     */
    public function itShouldEvaluateACorrectExpression()
    {
        $condition = new ExpressionCondition('user["active"] and product["price"] >= 25', $this->language);
        $context = new Context();

        $context->set('user', [
            'active' => true,
            'tags' => array('symfony2', 'hellofresh'),
        ]);

        $context->set('product', array(
            'price' => 30,
        ));

        $this->assertTrue($condition->holdsFor($context));
    }

    /**
     * @test
     */
    public function itShouldReturnsFalseIfTheConditionsAreNotMet()
    {
        $condition = new ExpressionCondition('"bootstrap" in user["tags"]', $this->language);
        $context = new Context();

        $context->set('user', [
            'active' => true,
            'tags' => array('symfony2', 'hellofresh'),
        ]);

        $this->assertFalse($condition->holdsFor($context));
    }

    /**
     * @test
     */
    public function itShouldReturnFalseIfTheExpressionDoesNotReturnBoolean()
    {
        $condition = new ExpressionCondition('user["tags"]', $this->language);
        $context = new Context();

        $context->set('user', [
            'active' => true,
            'tags' => array('symfony2', 'hellofresh'),
        ]);

        $this->assertFalse($condition->holdsFor($context));
    }
}
