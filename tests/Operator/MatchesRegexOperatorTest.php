<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Operator;

use HelloFresh\FeatureToggle\Operator\MatchesRegex;

class MatchesRegexOperatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider stringBeginningWith
     */
    public function itAppliesToStringsMatchingRegex($value, $argument)
    {
        $operator = new MatchesRegex($value);
        $this->assertTrue($operator->appliesTo($argument));
    }

    public function stringBeginningWith()
    {
        return array(
            array("/@foobar.com/", "barbaz@foobar.com"),
        );
    }

    /**
     * @test
     * @dataProvider stringNotContaining
     */
    public function itDoesNotApplyToStringsNotMatchingRegex($value, $argument)
    {
        $operator = new MatchesRegex($value);
        $this->assertFalse($operator->appliesTo($argument));
    }

    public function stringNotContaining()
    {
        return array(
            array("/^@foobar.com/", "barbaz@foobar.net"),
        );
    }

    /**
     * @test
     */
    public function itExposesItsValue()
    {
        $operator = new MatchesRegex("/^@foobar.com/");
        $this->assertEquals("/^@foobar.com/", $operator->getValue());
    }
}
