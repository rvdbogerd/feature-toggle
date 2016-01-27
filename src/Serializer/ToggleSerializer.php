<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle\Serializer;

use Collections\ArrayList;
use Collections\MapInterface;
use Collections\VectorInterface;
use HelloFresh\FeatureToggle\Feature;
use HelloFresh\FeatureToggle\FeatureInterface;
use HelloFresh\FeatureToggle\OperatorCondition;
use HelloFresh\FeatureToggle\ToggleStatus;
use HelloFresh\FeatureToggle\ToggleStrategy;

class ToggleSerializer
{
    private $operatorConditionSerializer;

    public function __construct(OperatorConditionSerializer $operatorConditionSerializer)
    {
        $this->operatorConditionSerializer = $operatorConditionSerializer;
    }

    /**
     * @param FeatureInterface $feature
     *
     * @return string
     */
    public function serialize(FeatureInterface $feature)
    {
        return [
            'name' => $feature->getName(),
            'conditions' => $this->serializeConditions($feature->getConditions()),
            'status' => $this->serializeStatus($feature),
            'strategy' => $this->serializeStrategy($feature)
        ];
    }

    /**
     * @param MapInterface $data
     *
     * @return FeatureInterface
     */
    public function deserialize(MapInterface $data)
    {
        /** @var MapInterface $conditions */
        $conditions = $data->get('conditions');

        if (!$conditions instanceof MapInterface) {
            throw new \RuntimeException('Key "conditions" should be an MapInterface.');
        }

        $toggle = new Feature(
            $data->get('name'),
            $this->deserializeConditions($conditions),
            $data->containsKey('strategy') ? $this->deserializeStrategy($data->get('strategy')) : ToggleStrategy::AFFIRMATIVE
        );
        if ($data->containsKey('status')) {
            $this->deserializeStatus($toggle, $data->get('status'));
        }

        return $toggle;
    }

    private function serializeConditions(VectorInterface $conditions)
    {
        $serialized = array();
        foreach ($conditions as $condition) {
            if (!$condition instanceof OperatorCondition) {
                throw new \RuntimeException(sprintf('Unable to serialize %s.', get_class($condition)));
            }
            $serialized[] = $this->operatorConditionSerializer->serialize($condition);
        }

        return $serialized;
    }

    private function deserializeConditions(MapInterface $conditions)
    {
        $deserialized = new ArrayList();
        foreach ($conditions as $condition) {
            $deserialized->add($this->operatorConditionSerializer->deserialize($condition));
        }

        return $deserialized;
    }

    private function serializeStatus(FeatureInterface $feature)
    {
        switch ($feature->getStatus()) {
            case ToggleStatus::ALWAYS_ACTIVE:
                return 'always-active';
            case ToggleStatus::INACTIVE:
                return 'inactive';
            case ToggleStatus::CONDITIONALLY_ACTIVE:
                return 'conditionally-active';
        }
    }

    private function deserializeStatus(FeatureInterface $feature, $status)
    {
        switch ($feature) {
            case 'always-active':
                $feature->activate(ToggleStatus::ALWAYS_ACTIVE);

                return;
            case 'inactive':
                $feature->deactivate();

                return;
            case 'conditionally-active':
                $feature->activate(ToggleStatus::CONDITIONALLY_ACTIVE);

                return;
        }
        throw new \RuntimeException(sprintf('Unknown toggle status "%s".', $status));
    }

    /**
     * @param FeatureInterface $feature
     *
     * @return string
     */
    private function serializeStrategy(FeatureInterface $feature)
    {
        switch ($feature->getStrategy()) {
            case ToggleStrategy::AFFIRMATIVE:
                return 'affirmative';
            case ToggleStrategy::MAJORITY:
                return 'majority';
            case ToggleStrategy::UNANIMOUS:
                return 'unanimous';
        }
    }

    /**
     * @param string $strategy
     *
     * @return int
     */
    private function deserializeStrategy($strategy)
    {
        switch ($strategy) {
            case 'affirmative':
                return ToggleStrategy::AFFIRMATIVE;
            case 'majority':
                return ToggleStrategy::MAJORITY;
            case 'unanimous':
                return ToggleStrategy::UNANIMOUS;
        }
        throw new \RuntimeException(sprintf('Unknown toggle strategy "%s".', $strategy));
    }
}
