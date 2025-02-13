# PHP-Navigation

[![GitHub Release][releases-badge]][releases-link]
![GitHub License][license-badge]
[![Packagist Downloads][packagist-badge]][packagist-link]

[releases-badge]: https://img.shields.io/github/v/release/feskol/php-navigation
[releases-link]: https://github.com/feskol/php-navigation/releases
[license-badge]: https://img.shields.io/github/license/feskol/php-navigation
[packagist-badge]: https://img.shields.io/packagist/dt/feskol/php-navigation
[packagist-link]: https://packagist.org/packages/feskol/php-navigation
[support-buy-me-coffee]: https://buymeacoffee.com/feskol
[support-badge-buy-me-coffee]: https://img.shields.io/badge/Buy%20Me%20a%20Coffee-ffdd00?&logo=buy-me-a-coffee&logoColor=black
[support-paypal-me]: https://paypal.me/feskol
[support-badge-paypal-me]: https://img.shields.io/badge/PayPal_Me-003087?logo=paypal&logoColor=fff

## Overview

A simple and effective Navigation to manage active states in navigation structures.

## Features

- Automatically tracks a link's active status and makes it easy to check if a parent navigation item has active child
  links.
- Easy to set up and integrate into existing projects.
- Flexible and extensible for complex navigation structures.

## Installation

Install via Composer:

```bash
composer require feskol/php-navigation
```

## Usage

### Building Your Navigation Structure

```php
use Feskol\Navigation\Link;
use Feskol\Navigation\Navigation;

// create links
$navLink = new Link();
$navLink->setTitle('Company')
    ->setHref('/company');
    
$subNavLink = new Link();
$subNavLink->setTitle('About us')
    ->setHref('/company/about-us')
    ->setIsActive(true);
    
// add the $subNavLink as $navLinks Child
$navLink->addChild($subNavLink);


// To have all links in one place you can use the provided Navigation class:
$navigation = new Navigation();
$navigation->setTitle('MyNavigation');

// add the created $navLink to the Navigation
$navigation->addLink($navLink);
```

Iterating through Navigation links:

```php
foreach ($navigation->getLinks() as $link){
    echo $link->getTitle(); // "Company"
    echo $link->hasActiveChildren(); // "true" - because the child is active
    
    foreach($link->getChildren() as $subLink){
        echo $link->getTitle(); // "About us"
        echo $link->isActive(); // "true"
    }
}
```

### Common link data

The `Link` class provides setter and getter methods for the common attributes of an `<a>`-tag.  
The most commonly used ones are `href=""` and `target=""`:

```php
use Feskol\Navigation\Link;

$link = new Link();

// href
$link->setHref('/company/about-us');
$link->getHref(); // "/company/about-us"

// target
$link->setTarget('_top');
$link->getTarget(); // "_top"

// for the common use of target="_blank" you can use:
$link->setTargetBlank();
$link->getTarget(); // "_blank"
```

To view all available methods for the common link data, check out the
[`AbsctractHyperLink` class](https://github.com/feskol/php-navigation/blob/main/src/AbstractHyperLink.php).

### Additional Data

There are often situations where you need additional data for your navigation, such as icons or images.  
The best approach is to create your own class (e.g. `MyCustomLink`) that extends the `Link` class:

```php
use Feskol\Navigation\Link;

class MyCustomLink extends Link
{
    private ?string $icon = null;
    
    public function getIcon(): ?string {
        return $this->icon;
    }
    
    public function setIcon(?string $icon): static {
        $this->icon = $icon;
        return $this;
    }
}
```

Then use your `MyCustomLink` class instead of the `Link` class:

```php
$link = new MyCustomLink();
$link->setTitle('Company')
    ->setHref('/company')
    ->setIcon('bi bi-user'); // For example, using Bootstrap-Icon classes
```

## Handling translations in your frontend

### Symfony

In Symfony, you can use the `TranslatableMessage` class to hold translation infos which you can use in your frontend.  
In Twig, apply the `|trans` filter to translate the `TranslatableMessage`.

Both the `Navigation` and `Link` classes accept any object implementing the  `\Stringable` interface in their
`setTitle()` methods.
This allows you to pass objects like `TranslatableMessage` or custom classes with a `__toString()` method.

#### Example in Symfony

```php
use Feskol\Navigation\Link;
use Feskol\Navigation\Navigation;
use Symfony\Component\Translation\TranslatableMessage;

$navigation = new Navigation();
$navigation->setTitle(new TranslatableMessage('MyNavigation', [], 'navigation'));

$navLink = new Link();
$navLink->setTitle(new TranslatableMessage(
    'Nav-Item for %customerName%',
    ['%customerName%' => $customer->getName()], // Dynamic translation parameters 
    'navigation' // Translation domain
));

$navigation->addLink($navLink);
```

And then in your Twig template:

````twig
{# @var \Feskol\Navigation\Navigation navigation #}  

Translated Navigation Title: {{ navigation.title|trans }}  

{% for link in navigation.links %}  
    Translated Link Title: {{ link.title|trans }}  
{% endfor %}  
````

## Contribution Guidelines

We welcome contributions to this project! To ensure clarity and fairness for all contributors, we require that all
contributors sign our **Contributor License Agreement (CLA)**.

By signing the CLA, you confirm that:

1. You grant us the perpetual, worldwide, non-exclusive, royalty-free, irrevocable right to use, modify, sublicense, and
   distribute your contribution as part of this project or any other project.
2. You retain ownership of your contribution, but grant us the rights necessary to use it without restriction.
3. Your contribution does not violate the rights of any third party.

### How to Sign the CLA

Before submitting a pull request, please sign the CLA using the following link:  
[Sign the CLA](https://cla-assistant.io/feskol/php-navigation)

Contributions cannot be merged unless the CLA is signed.

Thank you for your contributions and for helping us build something great!

## Testing

We're using phpunit.

Run tests:

```bash
php vendor/bin/phpunit
```

## ❤️ Support This Project

If you find this project helpful and would like to support my work:

- 🌟 **Star the repository** to show your appreciation.
- 💸 **Donate via**:
    - Buy Me a Coffe: [![Buy Me A Coffee][support-badge-buy-me-coffee]][support-buy-me-coffee]
    - PayPal: [![PayPal][support-badge-paypal-me]][support-paypal-me]

Thank you for your support!