<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle\Serializer;

use Collections\Dictionary;
use Collections\MapInterface;

class Serializer
{
    /**
     * @param array $data
     * @return MapInterface
     */
    public function deserialize(array $data)
    {
        $data = new Dictionary($data);

        $collection = new Dictionary();
        $serializer = new ToggleSerializer(new OperatorConditionSerializer(new OperatorSerializer()));
        foreach ($data as $name => $serializedToggle) {
            $toggle = $serializer->deserialize($serializedToggle);
            $collection->set($serializedToggle->get('name'), $toggle);
        }

        return $collection;
    }


    /**
     * @param MapInterface $features
     * @return array
     */
    public function serialize(MapInterface $features)
    {
        $serializer = new ToggleSerializer(new OperatorConditionSerializer(new OperatorSerializer()));
        $ret = [];
        foreach ($features as $key => $toggle) {
            $ret[$key] = $serializer->serialize($toggle);
        }

        return $ret;
    }
}