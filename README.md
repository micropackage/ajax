# Ajax

[![BracketSpace Micropackage](https://img.shields.io/badge/BracketSpace-Micropackage-brightgreen)](https://bracketspace.com)
[![Latest Stable Version](https://poser.pugx.org/micropackage/ajax/v/stable)](https://packagist.org/packages/micropackage/ajax)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/micropackage/ajax.svg)](https://packagist.org/packages/micropackage/ajax)
[![Total Downloads](https://poser.pugx.org/micropackage/ajax/downloads)](https://packagist.org/packages/micropackage/ajax)
[![License](https://poser.pugx.org/micropackage/ajax/license)](https://packagist.org/packages/micropackage/ajax)

## 🧬 About Ajax

This micropackage is a wrapper for WordPress AJAX responses in PHP.

## 💾 Installation

``` bash
composer require micropackage/ajax
```

## 🕹 Usage

### Basic usage

```php
use Micropackage\Ajax\Response;

function ajax_action_handler() {
	$response = new Response();

	// Handle nonce.
	$response->verify_nonce( $action = 'my_action', $query_arg = 'noncefield', $send_if_failed = true );

	// Do some checks and immediately send an error.
	if ( something_is_wrong() ) {
		$response->error( 'Error message' );
	}

	// This is never reached.
	$response->send( 'All good' );

}
```

### Error collecting

You can collect multiple errors in one response.

```php
use Micropackage\Ajax\Response;

function ajax_action_handler() {
	$response = new Response();

	// Do some checks.
	if ( something_is_wrong() ) {
		$response->add_error( 'Error message' );
	}

	// Do some checks.
	if ( something_else_is_wrong() ) {
		$response->add_error( 'Whoah!' );
	}

	// If no error added, the below message will be sent.
	$response->send( 'All good if no errors' );

}
```

### Sending data

```php
use Micropackage\Ajax\Response;

function ajax_action_handler() {
	$response = new Response();
	$response->send( $data_array );
}
```

## 📦 About the Micropackage project

Micropackages - as the name suggests - are micro packages with a tiny bit of reusable code, helpful particularly in WordPress development.

The aim is to have multiple packages which can be put together to create something bigger by defining only the structure.

Micropackages are maintained by [BracketSpace](https://bracketspace.com).

## 📖 Changelog

[See the changelog file](./CHANGELOG.md).

## 📃 License

GNU General Public License (GPL) v3.0. See the [LICENSE](./LICENSE) file for more information.
