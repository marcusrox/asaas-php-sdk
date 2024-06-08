<?php

use Adrianovcar\Asaas\Adapter\GuzzleHttpAdapter;
use Adrianovcar\Asaas\Asaas;
use Adrianovcar\Asaas\Entity\BillingType;
use Adrianovcar\Asaas\Entity\CreditCard;
use Adrianovcar\Asaas\Entity\CreditCardHolderInfo;
use Adrianovcar\Asaas\Entity\Fine;
use Adrianovcar\Asaas\Entity\Payment;
use Adrianovcar\Asaas\Entity\Subscription as SubscriptionEntity;
use Adrianovcar\Asaas\Entity\UpdatableSubscription;
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
    $customer = getOneCustomer($asaas);

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
        ->not()->toBeNull($customer->id);
});

test('create a new subscription', function () use ($asaas) {
    $customer = getOneCustomer($asaas);

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
    $subscription->billingType = BillingType::CREDIT_CARD;
    $subscription->value = 100;
    $subscription->cycle = SubscriptionEntity::CYCLE_MONTHLY;
    $subscription->description = 'Service subscription';
    $subscription->externalReference = '334433';
    $subscription->creditCard = $credit_card;
    $subscription->creditCardHolderInfo = $credit_card_holder;
    $subscription->fine = new Fine(['value' => 10, 'type' => 'PERCENTAGE']);

    $new_subscription = $asaas->subscription()->create($subscription);

    expect($new_subscription)
        ->not()->toBeEmpty($new_subscription->id);
})->skip();

test('create a new credit card payment', function () use ($asaas) {
    $customer = getOneCustomer($asaas);

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
    $payment->billingType = BillingType::CREDIT_CARD;
    $payment->value = 150.25;
    $payment->dueDate = '2024-06-03';
    $payment->description = 'Service payment via credit card';
    $payment->externalReference = 'id-55555';
    $payment->creditCard = $credit_card;
    $payment->creditCardHolderInfo = $credit_card_holder;

    expect($payment)
        ->not()->toBeEmpty($payment->id);
})->skip();

test('create a new slip', function () use ($asaas) {
    $customers = $asaas->customer()->getAll();
    $customer = $customers[0] ?? false;

    $payment = new Payment();
    $payment->customer = $customer->id;
    $payment->billingType = BillingType::SLIP;
    $payment->value = 39.90;
    $payment->dueDate = '2024-06-13';
    $payment->description = 'Service payment via slip';
    $payment->externalReference = 'id-777777';

    $payment = $asaas->payment()->create($payment);

    expect($payment)
        ->not()->toBeEmpty($payment->id);
})->skip();

test('list all subscriptions', function () use ($asaas) {
    $subscriptions = $asaas->subscription()->getAll();

    expect($subscriptions)
        ->not()->toBeEmpty(count($subscriptions));
})->skip();

test('list all payments', function () use ($asaas) {
    $payments = $asaas->payment()->getAll();

    expect($payments)
        ->not()->toBeEmpty(count($payments));
})->skip();

test('check if the subscription is in debt', function () use ($asaas) {
    $current_subscription = $asaas->subscription()->getById((getOneSubscription($asaas))->id ?? '');
    $result = $asaas->subscription()->inDebt($current_subscription->id);

    expect($result)->toBeBool($result);
});

test('check if the customer is in debt', function () use ($asaas) {
    $result = $asaas->customer()->inDebt((getOneCustomer($asaas))->id);

    expect($result)->toBeBool($result);
});

test('calculate a pro-rata plan', function () use ($asaas) {
    $current_subscription = $asaas->subscription()->getById((getOneSubscription($asaas))->id ?? '');

    $new_subscription = new UpdatableSubscription([
        'id' => $current_subscription->id,
        'value' => 300,
        'description' => 'New subscription - updated',
        'updatePendingPayments' => true,
        'externalReference' => '#new-subscription-id',
    ]);

    $subscription = $asaas->subscription()->evaluateProRata($current_subscription, $new_subscription);

    expect($subscription)
        ->not()->toBeEmpty($subscription->nextDueDate);
});

test('upgrade change a plan', function () use ($asaas) {
    $current_subscription = $asaas->subscription()->getById((getOneSubscription($asaas))->id ?? '');

    $params = [
        'id' => $current_subscription->id,
        'value' => 100,
        'description' => 'New subscription - updated',
        'updatePendingPayments' => true,
        'externalReference' => '#new-subscription-id',
    ];

    $new_subscription = new UpdatableSubscription($params);
    $subscription = $asaas->subscription()->changePlan($current_subscription, $new_subscription, true);

    expect($subscription)
        ->not()->toBeEmpty("{$subscription->nextDueDate} - {$subscription->value} - {$subscription->id}");
})->skip();

function getOneCustomer($asaas)
{
    $customers = $asaas->customer()->getAll();
    return $customers[0] ?? false;
}

function getOneSubscription($asaas)
{
    $subscription = $asaas->subscription()->getAll();
    return $subscription[0] ?? false;
}
