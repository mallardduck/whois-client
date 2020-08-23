# Whois Client PHP Library
[![Travis Build Status](https://travis-ci.org/mallardduck/php-whois-client.svg?branch=master)](https://travis-ci.org/mallardduck/php-whois-client)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/mallardduck/php-whois-client.svg)](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Latest Stable Version](https://poser.pugx.org/mallardduck/whois-client/v/stable)](https://packagist.org/packages/mallardduck/whois-client)
[![License](https://poser.pugx.org/mallardduck/whois-client/license)](https://packagist.org/packages/mallardduck/whois-client)
[![Coverage Status](https://coveralls.io/repos/github/mallardduck/php-whois-client/badge.svg?branch=master)](https://coveralls.io/github/mallardduck/php-whois-client?branch=master)

This package contains the most basic Whois (RFC3912) library for PHP possible. It provides a Whois client that requires lookup and server input to provide a raw Whois reponse.

Rather than focus on the user friendly output this library focuses on the raw Whois protocol. The library is limited in function since it's intended to be a low-level client that handles only request and raw output. Basically the package creates a client that has a telnet-esque experience. I.e. it accepts a server to connect to, creates a socket connection, sends a basic request to lookup and then provides the response.

## Requirements
* PHP >= 7.2

### Past PHP version support
| PHP | Package |
|-----|---------|
| 7.2 | Current |
| 7.1 | 1.1.1   |
| 7.0 | 0.4.0   |
| 5.6 | 0.3.0   |

## Features
* Pure PHP based Whois (RFC3912) client.
* Unicode IDN and punycode support.
* Simple API for getting raw Whois results in PHP.

## Installation
The best installation method is to simply use composer.

#### Stable version

`composer require mallardduck/whois-client`

#### Latest development version

`composer require "mallardduck/whois-client":"dev-master"`

### Example usage

```php
require 'vendor/autoload.php';

use MallardDuck\Whois\Client;

$client = new Client;
$results = $client->lookup('google.com');
```

## To-Do
### Before V2
This library will take a more minimalistc direction and a secondary library will provide a more guided experience. So anything in here that complicates the 'problem' of being a RFC 3912 client for PHP will be removed.
- [ ] Rip out anything that's not about being a thin RFC 3912 client.
- [ ] Consider removing IDN/punny support in favor of implementing in secondary library.

## License

Whois Client PHP Library is open source software licensed under the [GPLv3 license](LICENSE).
