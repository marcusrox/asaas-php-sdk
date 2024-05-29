<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Payment Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Payment extends AbstractEntity
{
    public int $id;
    public string $customer;
    public string $subscription;
    public string $externalReference;
    public string $billingType;
    public float $value;
    public float $netValue;
    public float $originalValue;
    public float $interestValue;
    public float $grossValue;
    public string $dueDate;
    public string $status;
    public string $nossoNumero;
    public string $description;
    public string $invoiceNumber;
    public string $invoiceUrl;
    public string $boletoUrl;
    public int $installmentCount;
    public bool $postalService;
    public float $installmentValue;
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

    /**
     * @param  string  $dueDate
     */
    public function setDueDate(string $dueDate): void
    {
        $this->dueDate = Payment::convertDateTime($dueDate);
    }
}
