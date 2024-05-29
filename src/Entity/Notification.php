<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Notification Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Notification extends AbstractEntity
{
    public int $id;
    public string $customer;
    public string $event;
    public int $scheduleOffset;
    public bool $emailEnabledForProvider;
    public bool $smsEnabledForProvider;
    public bool $emailEnabledForCustomer;
    public bool $smsEnabledForCustomer;
    public bool $enabled;
}
