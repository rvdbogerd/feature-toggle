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
use HelloFresh\FeatureToggle\Feature;
use HelloFresh\FeatureToggle\FeatureInterface;
use HelloFresh\FeatureToggle\FeatureManager;
use HelloFresh\FeatureToggle\Operator\LessThan;
use HelloFresh\FeatureToggle\OperatorCondition;

class FeatureManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddFeatures()
    {
        $operator = new LessThan(42);
        $conditions = new ArrayList([new OperatorCondition('value', $operator)]);

        $manager = new FeatureManager();
        $manager
            ->addFeature(new Feature('feature1', $conditions))
            ->addFeature(new Feature('feature2', $conditions));

        $context1 = new Context([
            'value' => 42
        ]);

        $context2 = new Context([
            'value' => 21
        ]);

        $this->assertFalse($manager->isActive('feature1', $context1));
        $this->assertTrue($manager->isActive('feature2', $context2));
    }

    /**
     * @expectedException \HelloFresh\FeatureToggle\Exception\FeatureAlreadyExistsException
     */
    public function testAddExistingFeature()
    {
        $conditions = new ArrayList();
        $manager = new FeatureManager();
        $manager
            ->addFeature(new Feature('feature1', $conditions))
            ->addFeature(new Feature('feature1', $conditions));
    }

    /**
     * @expectedException \HelloFresh\FeatureToggle\Exception\FeatureNotFoundException
     */
    public function testGetNotExistingFeature()
    {
        $conditions = new ArrayList();
        $manager = new FeatureManager();
        $manager
            ->addFeature(new Feature('feature1', $conditions));

        $manager->get('feature2');
    }

    public function testVerifyIfFeatureExistsAndIsEnabled()
    {
        $conditions = new ArrayList();
        $manager = new FeatureManager();
        $manager
            ->addFeature(new Feature('feature1', $conditions));

        $feature = $manager->get('feature1');
        $this->assertInstanceOf(FeatureInterface::class, $feature);
    }
}