<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle;

use Collections\ArrayList;
use HelloFresh\FeatureToggle\Context;
use HelloFresh\FeatureToggle\ExpressionCondition;
use HelloFresh\FeatureToggle\Feature;
use HelloFresh\FeatureToggle\FeatureManager;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class FeatureExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadFromYaml()
    {
        $language = new ExpressionLanguage();
        $expression = new ExpressionCondition('user["active"] and product["price"] / 100 >= 0.2', $language);

        $manager = new FeatureManager();
        $manager->addFeature(new Feature('feature1', new ArrayList([$expression])));

        $context = new Context();
        $context->set('user', [
            'active' => true
        ]);

        $context->set('product', [
            'price' => 30
        ]);

        $this->assertTrue($manager->isActive('feature1', $context));
    }
}