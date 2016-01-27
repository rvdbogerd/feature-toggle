<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle;

use HelloFresh\FeatureToggle\Feature;
use HelloFresh\FeatureToggle\FeatureInterface;
use HelloFresh\FeatureToggle\FeatureManager;
use HelloFresh\FeatureToggle\Toggle;

class FeatureManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddFeatures()
    {
        $manager = new FeatureManager();
        $manager
            ->addFeature(new Feature('feature1', Toggle::on()))
            ->addFeature(new Feature('feature2', Toggle::off()));

        $this->assertTrue($manager->get('feature1')->isEnabled());
        $this->assertFalse($manager->get('feature2')->isEnabled());
    }

    /**
     * @expectedException \HelloFresh\FeatureToggle\Exception\FeatureAlreadyExistsException
     */
    public function testAddExistingFeature()
    {
        $manager = new FeatureManager();
        $manager
            ->addFeature(new Feature('feature1', Toggle::on()))
            ->addFeature(new Feature('feature1', Toggle::off()));
    }

    /**
     * @expectedException \HelloFresh\FeatureToggle\Exception\FeatureNotFoundException
     */
    public function testGetNotExistingFeature()
    {
        $manager = new FeatureManager();
        $manager
            ->addFeature(new Feature('feature1', Toggle::on()));

        $manager->get('feature2');
    }

    public function testVerifyIfFeatureExistsAndIsEnabled()
    {
        $manager = new FeatureManager();
        $manager
            ->addFeature(new Feature('feature1', Toggle::on()));

        $feature = $manager->get('feature1');
        $this->assertInstanceOf(FeatureInterface::class, $feature);
        $this->assertTrue($feature->isEnabled());
    }

    public function testVerifyIfIsActive()
    {
        $manager = new FeatureManager();
        $manager
            ->addFeature(new Feature('feature1', Toggle::on()));
        
        $this->assertTrue($manager->isActive('feature1'));
    }
}