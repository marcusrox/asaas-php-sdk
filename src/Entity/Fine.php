<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Fine Entity
 *
 * Fine is a value that is charged to the customer after the due date.
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 */
final class Fine extends AbstractEntity
{
    /**
     * Fine percentage over the value of the charge after the due date
     * @var float
     */
    public float $value;

    /**
     * @var string "FIXED" or "PERCENTAGE"
     */
    public string $type;
}
