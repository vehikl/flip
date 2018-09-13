# Flip

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Flip is a simple Feature Toggle implementation. Features are implemented as independent classes and are "mixed" into
the class you want the feature to be exposed from.

## Install

Via Composer

``` bash
$ composer require vehikl/flip
```

## Usage

A Flip feature is just a regular PHP class with a few required methods.

`enabled` - This method returns a boolean value indicating if the feature is enabled or not

`toggles` - This method returns an array of available feature toggles. The array is keyed by the name of the method which
is called to run the feature. The value of each key is an associative array with keys `on` and `off`, each key
is mapped to the appropriate method to call depending on if the feature is "on" or "off". 

``` php
class SomeFeature extends \Vehikl\Flip\Feature
{
    /**
     * Decides under which conditions this Feature is enabled
     */
    public function enabled()
    {
        return random_int(0, 1) == 1;
    }

    /**
     * Returns an array of available toggles for this feature
     */
    public function toggles()
    {
        return [
            'someToggle' => [
                'on' => 'whenOn',
                'off' => 'whenOff'
            ]
        ];
    }
    
    public function whenOn()
    {
        return "I'm on!";
    }

    public function whenOff()
    {
        return "I'm off!";
    }
}

class SomeClass
{
    use Vehikl\Flip\Featurable;
    
    protected $features = [SomeFeature::class];
    
    public function someBehaviour()
    {
        // no need for if/else blocks, just call the toggle using the
        // `flip` helper
        return $this->flip()->someToggle();
    }
}
```

### Forcing Features to be On or Off

You can force a feature to be "on" or "off" by calling the `alwaysOn` or `alwaysOff` static methods respectively. This
will force all features of that class to be either "on" or "off" regardless of how their `enabled` methods evaluate.

```php
class SomeFeature extends \Vehikl\Flip\Feature
{
    // include the $forcedState static variable if you want to enable forcing state
    protected static $forcedState;
    
    /**
     * Decides under which conditions this Feature is enabled
     */
    public function enabled()
    {
        return random_int(0, 1) == 1;
    }

    /**
     * Returns an array of available toggles for this feature
     */
    public function toggles()
    {
        return [
            'someToggle' => [
                'on' => 'whenOn',
                'off' => 'whenOff'
            ]
        ];
    }
    
    public function whenOn()
    {
        return "I'm on!";
    }

    public function whenOff()
    {
        return "I'm off!";
    }
}

class SomeClass
{
    use Vehikl\Flip\Featurable;
    
    protected $features = [SomeFeature::class];
    
    public function someBehaviour()
    {
        // no need for if/else blocks, just call the toggle using the
        // `flip` helper
        return $this->flip()->someToggle();
    }
}

// force the SomeFeature feature to be always on
SomeFeature::alwaysOn()

// anytime `someToggle` is called on instances of SomeClass,
// the `on` version of `someToggle` will be run 
$someObject = new SomeClass;
$someObject->someBehaviour();  // always returns "I'm on!"
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email go@vehikl.com instead of using the issue tracker.

## Credits

- [Colin DeCarlo][link-colin]
- [Brad Brothers][link-brad]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/vehikl/flip.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/vehikl/flip/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/vehikl/flip.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/vehikl/flip.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/vehikl/flip.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/vehikl/flip
[link-travis]: https://travis-ci.org/vehikl/flip
[link-scrutinizer]: https://scrutinizer-ci.com/g/vehikl/flip/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/vehikl/flip
[link-downloads]: https://packagist.org/packages/vehikl/flip
[link-colin]: https://github.com/colindecarlo
[link-brad]: https://github.com/bbrothers
[link-contributors]: ../../contributors
