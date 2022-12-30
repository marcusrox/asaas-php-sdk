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
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $externalReference;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $company;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string
     */
    public $mobilePhone;

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
    public $address;
    /**
     * @var string
     */
    public $addressNumber;
    /**
     * @var string
     */
    public $complement;
    /**
     * @var string
     */
    public $province;
    /**
     * @var bool
     */
    public $foreignCustomer = false;
    /**
     * @var bool
     */
    public $notificationDisabled = true;
    /**
     * @var string
     */
    public $city;
    /**
     * @var string
     */
    public $state;
    /**
     * @var string
     */
    public $country;
    /**
     * @var string
     */
    public $postalCode;
    /**
     * @var string
     */
    public $cpfCnpj;
    /**
     * Person or Company, don't send to new customer
     * @var string
     */
    public $personType;
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
    public $deleted = false;
}
