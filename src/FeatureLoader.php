<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle;

use Collections\Dictionary;
use Symfony\Component\Yaml\Yaml;

/**
 * Feature class.
 */
class FeatureLoader
{
    public static function fromYaml($yaml)
    {
        return new Dictionary(Yaml::parse($yaml));
    }
}
