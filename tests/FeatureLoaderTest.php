<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle;

use HelloFresh\FeatureToggle\FeatureLoader;
use HelloFresh\FeatureToggle\FeatureManager;

class FeatureLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadFromYaml()
    {
        $yaml = <<<YML
feature_1: true
feature_2: false
feature_3: true
feature_4: false
YML;

        $features = FeatureLoader::fromYaml($yaml);
        $manager = new FeatureManager($features);

        $this->assertTrue($manager->isActive('feature_1'));
    }
}