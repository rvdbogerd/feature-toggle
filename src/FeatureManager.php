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
use Collections\MapInterface;
use HelloFresh\FeatureToggle\Exception\FeatureAlreadyExistsException;
use HelloFresh\FeatureToggle\Exception\FeatureNotFoundException;

class FeatureManager
{
    /**
     * @var MapInterface
     */
    protected $features;

    /**
     * FeatureManager constructor.
     * @param MapInterface $features
     */
    public function __construct(MapInterface $features = null)
    {
        $this->features = $features ? $features : new Dictionary();
    }

    public function addFeature(FeatureInterface $feature)
    {
        if ($this->has($feature->getName())) {
            throw new FeatureAlreadyExistsException(sprintf('The feature %s already exists', $feature->getName()));
        }

        $this->features->add($feature->getName(), $feature);

        return $this;
    }

    public function removeFeature(FeatureInterface $feature)
    {
        $this->features->removeKey($feature->getName());

        return $this;
    }

    public function has($name)
    {
        return $this->features->containsKey($name);
    }

    /**
     * Gets a feature toggle
     * @param $name - The name of the feature
     * @return FeatureInterface
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new FeatureNotFoundException(sprintf('The feature %s was not found', $name));
        }

        return $this->features->get($name);
    }

    public function isActive($name, Context $context)
    {
        return $this->get($name)->activeFor($context);
    }
}
