<?php
/**
 * Copyright (c) 2016, HelloFresh GmbH.
 * All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace HelloFresh\FeatureToggle;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * A condition written as a symfony language expression that gets evaluated against the
 * full context, allowing access to several keys of the context in a single condition
 */
class ExpressionCondition implements ConditionInterface
{
    /** @var string */
    protected $expression;

    /** @var ExpressionLanguage */
    protected $language;

    /**
     * @param string $expression The expression to ve evaluated
     * @param ExpressionLanguage $language The instance of the Expression Language
     */
    function __construct($expression, ExpressionLanguage $language)
    {
        $this->expression = $expression;
        $this->language = $language;
    }

    /**
     * @inheritdoc
     */
    public function holdsFor(Context $context)
    {
        return $this->language->evaluate($this->expression, $context->toArray()) === true;
    }
}