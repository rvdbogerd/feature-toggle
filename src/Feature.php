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
 * Feature class.
 */
class Feature implements FeatureInterface
{
    /** @var string */
    protected $name;

    /** @var VectorInterface */
    protected $conditions;

    /** @var  int */
    protected $status = ToggleStatus::CONDITIONALLY_ACTIVE;

    /** @var  int */
    protected $strategy = ToggleStrategy::AFFIRMATIVE;

    /**
     * Feature constructor.
     * @param $name - The name of the feature
     * @param VectorInterface $conditions - The conditions to be fulfilled
     * @param int $strategy The strategy to decide if the feature is enabled or not
     */
    public function __construct($name, VectorInterface $conditions, $strategy = ToggleStrategy::AFFIRMATIVE)
    {
        $this->name = $name;
        $this->conditions = $conditions;
        $this->strategy = $strategy;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @inheritdoc
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @inheritdoc
     */
    public function activate($status = ToggleStatus::CONDITIONALLY_ACTIVE)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function deactivate()
    {
        $this->status = ToggleStatus::INACTIVE;

        return $this;
    }

    /**
     * Checks whether the toggle is active for the given context.
     *
     * @param Context $context
     *
     * @return boolean True, if one of conditions hold for the context.
     */
    public function activeFor(Context $context)
    {
        switch ($this->status) {
            case ToggleStatus::ALWAYS_ACTIVE:
                return true;
            case ToggleStatus::INACTIVE:
                return false;
            case ToggleStatus::CONDITIONALLY_ACTIVE:
                switch ($this->strategy) {
                    case ToggleStrategy::AFFIRMATIVE:
                        return $this->atLeastOneConditionHolds($context);
                    case ToggleStrategy::MAJORITY:
                        return $this->moreThanHalfConditionsHold($context);
                    case ToggleStrategy::UNANIMOUS:
                        return $this->allConditionsHold($context);
                }
        }
    }

    /**
     * @param Context $context
     *
     * @return bool
     */
    private function atLeastOneConditionHolds(Context $context)
    {
        /** @var ConditionInterface $condition */
        foreach ($this->conditions as $condition) {
            if ($condition->holdsFor($context)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Context $context
     *
     * @return bool
     */
    private function moreThanHalfConditionsHold(Context $context)
    {
        $nbPositive = 0;
        $nbNegative = 0;

        /** @var ConditionInterface $condition */
        foreach ($this->conditions as $condition) {
            $condition->holdsFor($context) ? $nbPositive++ : $nbNegative++;
        }

        return $nbPositive > $nbNegative;
    }

    /**
     * @param Context $context
     *
     * @return bool
     */
    private function allConditionsHold(Context $context)
    {
        /** @var ConditionInterface $condition */
        foreach ($this->conditions as $condition) {
            if (!$condition->holdsFor($context)) {
                return false;
            }
        }

        return true;
    }
}
