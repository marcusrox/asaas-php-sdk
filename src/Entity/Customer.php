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
    public ?string $id;
    public string $name;
    /**
     * This is a required field
     */
    public string $cpfCnpj;
    public string $email;
    public string $phone;
    public string $mobilePhone;
    public string $address;
    public string $addressNumber;
    public string $complement;
    /**
     * neighborhood
     */
    public string $province;
    public string $postalCode;
    public string $externalReference;
    public bool $notificationDisabled = true;
    /**
     * Aditional email for sending notifications, comma separeted ","
     */
    public string $additionalEmails;
    public string $municipalInscription;
    public string $stateInscription;
    public string $observations;
    /**
     * @var string Nome do grupo ao qual o cliente pertence
     */
    public string $groupName;
    public string $company;
    /**
     * When a customer was deleted from ASAAS
     */
    public bool $deleted = false;

    protected int $city;
    protected string $cityName;
    protected string $personType;
    protected string $state;
    protected string $country;
    protected string $dateCreated;

    /**
     * @var Subscription[]
     */
    protected array $subscriptions = [];
    /**
     * @var Payment[]
     */
    protected array $payments = [];
    /**
     * @var Notification[]
     */
    protected array $notifications = [];
}
