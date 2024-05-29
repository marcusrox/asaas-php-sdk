<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Subscription Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Subscription extends AbstractEntity
{
    public ?int $id;
    public string $customer;
    public float $value;
    public float $grossValue;
    public string $nextDueDate;
    public string $cycle;
    public string $billingType;
    public string $description;
    public bool $updatePendingPayments;
    public array $payments = [];
    public string $creditCardHolderName;
    public string $creditCardNumber;
    public string $creditCardExpiryMonth;
    public string $creditCardExpiryYear;
    public string $creditCardCcv;
    public string $creditCardHolderFullName;
    public string $creditCardHolderEmail;
    public string $creditCardHolderCpfCnpj;
    public string $creditCardHolderAddress;
    public string $creditCardHolderAddressNumber;
    public string $creditCardHolderAddressComplement;
    public string $creditCardHolderProvince;
    public string $creditCardHolderCity;
    public string $creditCardHolderUf;
    public string $creditCardHolderPostalCode;
    public string $creditCardHolderPhone;
    public string $creditCardHolderPhoneDDD;
    public string $creditCardHolderMobilePhone;
    public string $creditCardHolderMobilePhoneDDD;
    public int $maxPayments;
    public string $endDate;

    /**
     * @param  string  $nextDueDate
     */
    public function setNextDueDate(string $nextDueDate)
    {
        $this->nextDueDate = Subscription::convertDateTime($nextDueDate);
    }

    /**
     * @param  string  $endDate
     */
    public function setEndDate(string $endDate)
    {
        $this->endDate = Subscription::convertDateTime($endDate);
    }
}
