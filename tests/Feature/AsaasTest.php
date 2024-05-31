<?php

use Adrianovcar\Asaas\Adapter\GuzzleHttpAdapter;
use Adrianovcar\Asaas\Asaas;
use Adrianovcar\Asaas\Entity\CreditCard;
use Adrianovcar\Asaas\Entity\CreditCardHolderInfo;
use Adrianovcar\Asaas\Entity\Fine;
use Adrianovcar\Asaas\Entity\Subscription as SubscriptionEntity;
use function Pest\Faker\fake;

global $asaas, $adapter, $customer;

test('avoid dd, dump, ray, ds')
    ->expect(['dd', 'dump', 'ray', 'ds'])
    ->not->toBeUsed();

// replace with your access token
$accessToken = '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwMDE2OTc6OiRhYWNoXzEzZmZmMDE0LWFhM2MtNDIwZS1iMmFmLTA4YzcwNjY4MDkxNA==';
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
    $subscription->billingType = SubscriptionEntity::BILLING_TYPE_CREDIT_CARD;
    $subscription->value = 10.50;
    $subscription->cycle = SubscriptionEntity::CYCLE_MONTHLY;
    $subscription->description = 'Service subscription';
    $subscription->externalReference = '334433';
    $subscription->creditCard = $credit_card;
    $subscription->creditCardHolderInfo = $credit_card_holder;
    $subscription->fine = new Fine(['value' => 10, 'type' => 'PERCENTAGE']);

    $new_subscription = $asaas->subscription()->create($subscription);

    expect($new_subscription)
        ->not()->toBeEmpty();
});

//
//test('list all subscriptions', function () use ($asaas, $adapter) {
//    $subscriptions = $asaas->subscription()->getAll();
//
//    expect($subscriptions)
//        ->not()->toBeEmpty();
//});
