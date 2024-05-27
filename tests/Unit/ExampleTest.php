<?php

use Adrianovcar\Asaas\Adapter\GuzzleHttpAdapter;
use Adrianovcar\Asaas\Asaas;

test('example', function () {
    $adapter = new GuzzleHttpAdapter('yout-asaas-token-here');
    $asaas = new Asaas($adapter, 'sandbox');

    var_dump($asaas->customer()->getAll());
});
