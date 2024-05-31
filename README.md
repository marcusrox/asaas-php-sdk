Asaas.com PHP-SDK
=================

SDK for integration with the [www.asaas.com](https://www.asaas.com) service API

In addition to offering a payment gateway service, ASAAS also offers several other financial services, including acting as a BaaS (bank as a service).

This SDK is being developed with a focus on the most frequent operations. In this version, this SDK covers the following ASAAS features:

- Customers (CRUD)
- Payments (CRUD)
- Subscriptions (CRUD)

Installation
----------

The library can be installed using the composer dependency manager. To install the library and all its dependencies, run:

```bash
composer require adrianovcar/asaas-php-sdk:2.0
```

Adapters
--------

From version 2.0, other adapters were removed and we started to maintain only the `GuzzleHttpAdapter`;

Example
-------

```php
<?php

require 'vendor/autoload.php';

use Adrianovcar\Asaas\Adapter\GuzzleHttpAdapter;
use Adrianovcar\Asaas\Asaas;

$adapter = new GuzzleHttpAdapter('your_access_token');

// Instantiate the Asaas client using the previously created adapter instance.
$asaas = new Asaas($adapter);
```

Endpoint
--------

If you want to use the API in test mode, just specify the `environment` when the client is instantiated.

```php
// Note: If the second parameter is not informed, the API enters production mode
$asaas = new Asaas($adapter, 'sandbox|production');
```

Customers
--------

```php
// Returns the list of customers according to the filter used (https://docs.asaas.com/reference/listar-clientes)
$clientes = $asaas->customer()->getAll(array $filtros);

// Returns the customer's data according to the Id
$cobranca = $asaas->customer()->getById('cus_123123');

// Returns the customer's data according to the email
$clientes = $asaas->customer()->getByEmail('email@mail.com');

// Inserts a new customer
$cobranca = $asaas->customer()->create(array $dadosCliente);

// Updates the customer's data
$cobranca = $asaas->customer()->update('cus_123123', array $dadosCliente);

// Deletes a customer
$asaas->customer()->delete('cus_123123');
```

Payments
------------

```php
// Returns the list of payments
$cobrancas = $asaas->payment()->getAll(array $filtros);

// Returns the payment data according to the Id
$cobranca = $asaas->payment()->getById('pay_123123');

// Returns the list of payments according to the Customer Id
$cobrancas = $asaas->payment()->getByCustomer($customer_id);

// Returns the list of payments according to the Subscriptions Id
$cobrancas = $asaas->payment()->getBySubscription($subscription_id);

// Inserts a new payment
$cobranca = $asaas->payment()->create(array $dadosCobranca);

// Updates the payment data
$cobranca = $asaas->payment()->update('pay_123123', array $dadosCobranca);

// Deletes a payment
$asaas->payment()->delete('pay_123123');
```

Subscriptions
------------

```php
// Returns the list of subscriptions
$assinaturas = $asaas->subscription()->getAll(array $filtros);

// Returns the subscription data according to the Id
$assinatura = $asaas->subscription()->getById('sub_123123');

// Returns the list of subscriptions according to the Customer Id
$assinaturas = $asaas->subscription()->getByCustomer($customer_id);

// Inserts a new subscription
$assinatura = $asaas->subscription()->create(array $dadosAssinatura);

// Updates the subscription data
$assinatura = $asaas->subscription()->update('sub_123123', array $dadosAssinatura);

// Deletes a subscription
$asaas->subscription()->delete('sub_123123');
```

Notifications
------------

```php
// Returns the list of notifications
$notificacoes = $asaas->notification()->getAll(array $filtros);

// Returns the notification data according to the Id
$notificacao = $asaas->notification()->getById('not_123123');

// Returns the list of notifications according to the Customer Id
$notificacoes = $asaas->notification()->getByCustomer($customer_id);

// Inserts a new notification
$notificacao = $asaas->notification()->create(array $dadosNotificacao);

// Updates the notification data
$notificacao = $asaas->notification()->update('not_123123', array $dadosNotificacao);

// Deletes a notification
$asaas->notification()->delete('not_123123');
```

Cities
------

```php
// Returns the list of cities
$cidades = $asaas->city()->getAll(array $filtros);

// Returns the city data according to the Id
$action123 = $asaas->city()->getById(123);
```

Official Documentation
--------------------

The ASAAS documentation is extensive and very complete. For details on each endpoint, consult [the official documentation](https://docs.asaas.com/reference/comece-por-aqui).


Credits
--------

* Adriano Carrijo ([Moblues Code Studio](https://moblu.es))
* Original fork: [Agência Softr Ltda - www.softr.com.br](http://www.softr.com.br)

Changelog
-------

Consult the updates of this SDK in the [changelog](http://github.com/adrianovcar/php-asaas-skd/CHANGELOG.md)

Support
-------

[To report a new bug please open a new Issue on github](https://github.com/adrianovcar/asaas-php-sdk/issues)


License
-------

Distributed under the MIT license. Copy, paste, modify, improve and share without fear ;)
