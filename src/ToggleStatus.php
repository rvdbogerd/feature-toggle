<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle;

final class ToggleStatus
{
    const CONDITIONALLY_ACTIVE = 1;
    const ALWAYS_ACTIVE = 2;
    const INACTIVE = 4;
}