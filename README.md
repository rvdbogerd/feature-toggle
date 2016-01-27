# Feature Toogle

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
  use HelloFresh\FeatureToggle\Toggle;
  use HelloFresh\FeatureToggle\Feature;
  
  $manager = new FeatureManager();
  $manager
    ->addFeature(new Feature('feature_1', Toggle:on()))
    ->addFeature(new Feature('feature_2', Toggle:off()))
    ->addFeature(new Feature('feature_3', Toggle:on()))
    ->addFeature(new Feature('feature_4', Toggle:off()))
    ;
  
  if ($manager->isActive('feature_2')) {
       // The feature is active \o/ 
  }
```

Loading features from yaml files

```php
    use HelloFresh\FeatureToggle\FeatureManager;
    use HelloFresh\FeatureToggle\FeatureLoader;
  
    $yaml = <<<YML
    feature_1: true
    feature_2: false
    feature_3: true
    feature_4: false
    YML;
    
    $features = FeatureLoader::fromYaml($yaml);
    $manager = new FeatureManager($features);
    
    $this->assertTrue($manager->isActive('feature_1'));
```
## Contributing

Please see [CONTRIBUTING](https://github.com/hellofresh/feature-toggle/blob/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/hellofresh/feature-toggle/blob/master/LICENSE) for more information.
