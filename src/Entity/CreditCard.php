<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Credit Card Entity
 *
 * Credit card information entity to be used in payments
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 */
final class CreditCard extends AbstractEntity
{
    public string $holderName;
    public string $number;
    public string $expiryMonth;
    /**
     * @var string Expiry year with 4 digits
     */
    public string $expiryYear;
    public string $ccv;

}
