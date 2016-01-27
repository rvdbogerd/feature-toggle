<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle;

use Collections\VectorInterface;

/**
 * Represents a feature that can be toggle on or off
 */
interface FeatureInterface
{
    /**
     * Is the feature enabled?
     * @param Context $context
     * @return bool
     */
    public function activeFor(Context $context);

    /**
     * Activates a feature
     * @param int $status
     * @return $this
     */
    public function activate($status = ToggleStatus::CONDITIONALLY_ACTIVE);

    /**
     * Deactivates a feature
     * @return $this
     */
    public function deactivate();

    /**
     * Gets the name of the feature
     * @return string
     */
    public function getName();

    /**
     * @return int
     */
    public function getStrategy();

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @return VectorInterface
     */
    public function getConditions();
}
