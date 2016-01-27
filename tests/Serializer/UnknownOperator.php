<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Tests\HelloFresh\FeatureToggle\Serializer;

use HelloFresh\FeatureToggle\Operator\OperatorInterface;

class UnknownOperator implements OperatorInterface
{
    public function appliesTo($argument)
    {
        return true;
    }
}
