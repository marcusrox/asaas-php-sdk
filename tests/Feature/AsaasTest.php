<?php

use Adrianovcar\Asaas\Adapter\GuzzleHttpAdapter;
use Adrianovcar\Asaas\Asaas;
use Adrianovcar\Asaas\Entity\CreditCard;
use Adrianovcar\Asaas\Entity\CreditCardHolderInfo;
use Adrianovcar\Asaas\Entity\Fine;
use Adrianovcar\Asaas\Entity\Payment;
use Adrianovcar\Asaas\Entity\Subscription as SubscriptionEntity;
use function Pest\Faker\fake;

global $asaas, $adapter, $customer;

test('avoid dd, dump, ray, ds')
    ->expect(['dd', 'dump', 'ray', 'ds'])
    ->not->toBeUsed();

// replace with your access token
$accessToken = 'your-token-here';
$adapter = new GuzzleHttpAdapter($accessToken);
$asaas = new Asaas($adapter, 'sandbox');

test('init asaas class', function () use ($asaas, $adapter) {
    $null_user = $asaas->customer()->getByEmail('user@notexists.com');
    expect($null_user->id)->toBeNull();
});

test('list all users', function () use ($asaas, $adapter) {
    $customers = $asaas->customer()->getAll();
    $customer = $customers[0] ?? false;

    if (!$customer->id) {
        $defaultData = [
            'name' => fake('pt_BR')->name(),
            'email' => fake('pt_BR')->email(),
            'cpfCnpj' => cpf::cpfRandom(),
            'company' => fake('pt_BR')->company(),
            'phone' => fake('pt_BR')->phoneNumber(),
            'mobilePhone' => fake('pt_BR')->phoneNumber(),
            'postalCode' => '13045-135',
            'addressNumber' => '605',
        ];

        $customer = $asaas->customer()->create($defaultData);
    }

    expect($customer->id)
        ->not()->toBeNull();
});

test('create a new subscription', function () use ($asaas) {

    $customers = $asaas->customer()->getAll();
    $customer = $customers[0] ?? false;

    $credit_card = (new CreditCard())->fill();
    $credit_card_holder = new CreditCardHolderInfo();
    $credit_card_holder->name = $credit_card->holderName;
    $credit_card_holder->email = fake()->email();
    $credit_card_holder->phone = fake('pt_BR')->phoneNumber();
    $credit_card_holder->mobilePhone = fake('pt_BR')->phoneNumber();
    $credit_card_holder->cpfCnpj = cpf::cpfRandom();
    $credit_card_holder->addressNumber = fake()->buildingNumber();
    $credit_card_holder->addressComplement = 'complemento';
    $credit_card_holder->postalCode = '01153-000';

    $subscription = new SubscriptionEntity();
    $subscription->customer = $customer->id;
    $subscription->billingType = Payment::TYPE_CREDIT_CARD;
    $subscription->value = 10.50;
    $subscription->cycle = Payment::CYCLE_MONTHLY;
    $subscription->description = 'Service subscription';
    $subscription->externalReference = '334433';
    $subscription->creditCard = $credit_card;
    $subscription->creditCardHolderInfo = $credit_card_holder;
    $subscription->fine = new Fine(['value' => 10, 'type' => 'PERCENTAGE']);

    $new_subscription = $asaas->subscription()->create($subscription);

    expect($new_subscription)
        ->not()->toBeEmpty();
});

test('create a new credit card payment', function () use ($asaas) {
    $customers = $asaas->customer()->getAll();
    $customer = $customers[0] ?? false;

    $credit_card = (new CreditCard())->fill();
    $credit_card_holder = new CreditCardHolderInfo();
    $credit_card_holder->name = $credit_card->holderName;
    $credit_card_holder->email = fake()->email();
    $credit_card_holder->phone = fake('pt_BR')->phoneNumber();
    $credit_card_holder->mobilePhone = fake('pt_BR')->phoneNumber();
    $credit_card_holder->cpfCnpj = cpf::cpfRandom();
    $credit_card_holder->addressNumber = fake()->buildingNumber();
    $credit_card_holder->addressComplement = 'complemento';
    $credit_card_holder->postalCode = '01153-000';

    $payment = new Payment();
    $payment->customer = $customer->id;
    $payment->billingType = Payment::TYPE_CREDIT_CARD;
    $payment->value = 150.25;
    $payment->dueDate = '2024-06-03';
    $payment->description = 'Service payment via credit card';
    $payment->externalReference = 'id-55555';
    $payment->creditCard = $credit_card;
    $payment->creditCardHolderInfo = $credit_card_holder;

    expect($payment)
        ->not()->toBeEmpty();
});

test('create a new slip', function () use ($asaas) {
    $customers = $asaas->customer()->getAll();
    $customer = $customers[0] ?? false;

    $payment = new Payment();
    $payment->customer = $customer->id;
    $payment->billingType = Payment::TYPE_SLIP;
    $payment->value = 39.90;
    $payment->dueDate = '2024-06-13';
    $payment->description = 'Service payment via slip';
    $payment->externalReference = 'id-777777';

    $payment = $asaas->payment()->create($payment);

    var_dump($payment);

    expect($payment)
        ->not()->toBeEmpty();
});

test('list all subscriptions', function () use ($asaas) {
    $subscriptions = $asaas->subscription()->getAll();

    expect($subscriptions)
        ->not()->toBeEmpty();
});

test('list all payments', function () use ($asaas) {
    $payments = $asaas->payment()->getAll();

    expect($payments)
        ->not()->toBeEmpty();
});
