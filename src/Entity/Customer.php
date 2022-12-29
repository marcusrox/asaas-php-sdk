<?php
namespace Softr\Asaas\Entity;

/**
 * Customer Entity
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Customer extends \Softr\Asaas\Entity\AbstractEntity
{
    /**
     * ASAAS internal ID, example "cus_000005075481"
     */
    public string $id;
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public $externalReference;
    /**
     * @var string
     */
    public string $email;
    /**
     * @var string
     */
    public string $company;
    /**
     * @var string
     */
    public string $phone;
    /**
     * @var string
     */
    public string $mobilePhone;

    /**
     * Aditional email for sending notifications, comma separeted ","
     * @var string
     */
    public $additionalEmails;

    /**
     * When the customer is a company
     */
    public $municipalInscription;
    /**
     * @var string
     */
    public string $address;
    /**
     * @var string
     */
    public string $addressNumber;
    /**
     * @var string
     */
    public string $complement;
    /**
     * @var string
     */
    public string $province;
    /**
     * @var bool
     */
    public bool $foreignCustomer = false;
    /**
     * @var bool
     */
    public $notificationDisabled = true;
    /**
     * @var string
     */
    public string $city;
    /**
     * @var string
     */
    public string $state;
    /**
     * @var string
     */
    public string $country;
    /**
     * @var string
     */
    public string $postalCode;
    /**
     * @var string
     */
    public string $cpfCnpj;
    /**
     * Person or Company, don't send to new customer
     */
    public string $personType;
    /**
     * @var array
     */
    public array $subscriptions = [];
    /**
     * @var array
     */
    public array $payments = [];
    /**
     * @var array
     */
    public array $notifications = [];
    /**
     * When a customer was deleted from ASAAS
     * @var bool
     */
    public bool $deleted = false;
}
