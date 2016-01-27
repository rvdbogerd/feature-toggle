# Feature Toogle

[![Build Status](https://travis-ci.org/hellofresh/feature-toggle.svg?style=flat-square)](https://travis-ci.org/hellofresh/feature-toggle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hellofresh/feature-toggle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/hellofresh/feature-toggle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/hellofresh/feature-toggle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hellofresh/feature-toggle/?branch=master)
[![Latest Stable Version](http://img.shields.io/packagist/v/hellofresh/feature-toggle.svg?style=flat-square)](https://packagist.org/packages/hellofresh/feature-toggle/)
[![Downloads](https://img.shields.io/packagist/dt/hellofresh/feature-toggle.svg?style=flat-square)](https://packagist.org/packages/hellofresh/feature-toggle/)

A simple feature toggle mechanism for PHP.

If you don't know the feature toggle pattern please read [this](http://martinfowler.com/bliki/FeatureToggle.html)

## Install

``` bash
$ composer require hellofresh/feature-toogle
```

## Usage

Let's define a new feature toggle list

```php
  use HelloFresh\FeatureToggle\FeatureManager;
  use HelloFresh\FeatureToggle\Feature;
  use HelloFresh\FeatureToggle\OperatorCondition;
  use HelloFresh\FeatureToggle\Context;
  use Collections\ArrayList;
  
  $operator = new LessThan(42);
  $conditions = new ArrayList([new OperatorCondition('user_id', $operator)]);

  $manager = new FeatureManager();
  $manager
      ->addFeature(new Feature('feature1', $conditions))
      ->addFeature(new Feature('feature2', $conditions))
      ->addFeature(new Feature('feature3', $conditions))
      ->addFeature(new Feature('feature4', $conditions))
  ;

  $context = new Context([
      'user_id' => 42
  ]);
          
  if ($manager->isActive('feature2', $context)) {
       // The feature is active \o/ 
  }
```

Loading features from yaml files

```php
    use HelloFresh\FeatureToggle\Context;
    use HelloFresh\FeatureToggle\FeatureManager;
    use HelloFresh\FeatureToggle\Serializer\Serializer;
    use Symfony\Component\Yaml\Yaml;
  
    $yaml = <<<YML
features:
  - name: some-feature
    conditions:
     - name: operator-condition
       key: user_id
       operator:
           name: greater-than
           value: 41
       status: conditionally-active
  - name: some-feature2
    conditions:
     - name: operator-condition
       key: user_id
       operator:
           name: greater-than
           value: 42
       status: conditionally-active
YML;

    $serializer = new Serializer();

    $features = $serializer->deserialize(Yaml::parse($yaml)['features']);
    $manager = new FeatureManager($features);

    $context = new Context();
    $context->set('user_id', 42);

    if ($manager->isActive('feature2', $context)) {
           // The feature is active \o/ 
    }
```

What about using an expression?

```php
use HelloFresh\FeatureToggle\FeatureManager;
use HelloFresh\FeatureToggle\Feature;
use HelloFresh\FeatureToggle\ExpressionCondition;
use HelloFresh\FeatureToggle\Context;
use Collections\ArrayList;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

$language   = new ExpressionLanguage();
$expression = new ExpressionCondition('user["active"] and product["price"] / 100 >= 0.2', $language);

$manager = new FeatureManager();
$manager->addFeature(new Feature('feature1', $expression));

// Create and check a new context and condition using symfony expression
$context = new Context();
$context->set('user', [
    'active' => true
]);

$context->set('product', [
    'price' => 30
]);
      
if ($manager->isActive('feature2', $context)) {
   // The feature is active \o/ 
}

```
## Contributing

Please see [CONTRIBUTING](https://github.com/hellofresh/feature-toggle/blob/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/hellofresh/feature-toggle/blob/master/LICENSE) for more information.
