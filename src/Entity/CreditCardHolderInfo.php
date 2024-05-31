<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Credit Card Holder Info Entity
 *
 * Credit card holder information
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 */
final class CreditCardHolderInfo extends AbstractEntity
{
    /**
     * required
     * @var string owner full name
     */
    public string $name;
    /**
     * required
     * @var string owner email
     */
    public string $email;
    /**
     * required
     * @var string owner document
     */
    public string $cpfCnpj;
    /**
     * required
     * @var string owner postal code
     */
    public string $postalCode;
    /**
     * required
     * @var string owner address number
     */
    public string $addressNumber;
    public string $addressComplement;
    /**
     * required
     * @var string owner phone number
     */
    public string $phone;
    public string $mobilePhone;


}
