<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Interest Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 */
final class Interest extends AbstractEntity
{
    /**
     * Percentage of interest per month on the value of the invoice for payment after the due date.
     * @var float
     */
    public float $value;
    public string $type;
}
