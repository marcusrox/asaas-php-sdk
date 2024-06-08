<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Subscription Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 */
final class UpdatableSubscription extends AbstractEntity
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    public ?string $id;
    public string $billingType;
    public float $value;
    public string $status;
    public ?string $nextDueDate;
    public ?Discount $discount;
    public ?Interest $interest;
    public ?Fine $fine;
    public string $cycle;
    public string $description;
    public ?string $endDate;
    public bool $updatePendingPayments = true;
    public ?string $externalReference;
    public ?array $split; // Todo: Implement split feature
    public ?array $callback; // Todo: Implement callback feature
}
