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
use HelloFresh\FeatureToggle\FeatureManager;
use HelloFresh\FeatureToggle\Serializer\Serializer;
use Symfony\Component\Yaml\Yaml;

class FeatureLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadFromYaml()
    {
        $yaml = <<<YML
features:
  - name: some-feature
    conditions:
     - name: operator-condition
       key: user_id
       operator:
           name: greater-than
           value: 41
       status: conditionally-active
  - name: some-feature2
    conditions:
     - name: operator-condition
       key: user_id
       operator:
           name: greater-than
           value: 42
       status: conditionally-active
YML;

        $serializer = new Serializer();

        $features = $serializer->deserialize(Yaml::parse($yaml)['features']);
        $manager = new FeatureManager($features);

        $context = new Context();
        $context->set('user_id', 42);

        $this->assertTrue($manager->isActive('some-feature', $context));
    }
}