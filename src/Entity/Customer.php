<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Customer Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Customer extends AbstractEntity
{
    /**
     * ASAAS internal ID, example "cus_000005075481"
     */
    public string $id;
    public string $name;
    public string $externalReference;
    public string $email;
    public string $company;
    public string $phone;
    public string $mobilePhone;
    /**
     * Aditional email for sending notifications, comma separeted ","
     */
    public string $additionalEmails;
    public string $municipalInscription;
    public string $address;
    public string $addressNumber;
    public string $complement;
    /**
     * neighborhood
     */
    public string $province;
    public bool $notificationDisabled = true;
    public string $city;
    public string $state;
    public string $country;
    public string $postalCode;
    /**
     * This is a required field
     */
    public string $cpfCnpj;
    public array $subscriptions = [];
    public array $payments = [];
    public array $notifications = [];
    /**
     * When a customer was deleted from ASAAS
     */
    public bool $deleted = false;
}
