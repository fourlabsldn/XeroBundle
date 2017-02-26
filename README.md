# XeroBundle

[![StyleCI](https://styleci.io/repos/73813542/shield?branch=master)](https://styleci.io/repos/73813542)
[![Total Downloads](https://poser.pugx.org/fourlabs/xero-bundle/downloads)](https://packagist.org/packages/fourlabs/xero-bundle)

This is a Symfony bundle wrapping the [XeroPHP](https://github.com/calcinai/xero-php) library. From the library's github page:

> A client implementation of the [Xero API](https://developer.xero.com), with a cleaner OAuth interface and ORM-like abstraction.
>
> I hate reinventing the wheel, but this was written out of desperation. I wasn't comfortable putting the implementation that's recommended by Xero in to production, even after persisting with extending it.
>
> This is loosely based on the functional flow of XeroAPI/XeroOAuth-PHP, but is split logically into more of an OO design.


## Download the bundle using composer

```bash
composer require fourlabs/xero-bundle
```

## Enable the bundle

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FL\XeroBundle\FLXeroBundle(),
        // ...
    );
}
```
## Configure the bundle

For a full configuration reference use:

```bash
php bin/console config:dump-reference FLXeroBundle
```

Example of a private app configuration:
 
```yml
fl_xero:
  type: private
  oauth:
    callback: "https://mydomain.com/xero-callback"
    consumer_key: "%xero_consumer_key%"
    consumer_secret: "%xero_consumer_secret%"
    rsa_private_key: "file://%kernel.root_dir%/Resources/Xero/private.pem"
  curl:
    CURLOPT_USERAGENT: XeroPHP Test App
```

# Usage

Using the Xero service in your controller:

```php
$xero = $this->get('fl_xero.app');

$contacts = $xero->load('Accounting\\Contact')->execute();
foreach ($contacts as $contact) {
    var_dump($contact);
}
```
