<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle;

final class ToggleStrategy
{
    const AFFIRMATIVE = 1;
    const MAJORITY = 2;
    const UNANIMOUS = 3;
}
