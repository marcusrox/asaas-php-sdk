<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Discount Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 */
final class Discount extends AbstractEntity
{
    /**
     * Fixed or percentual value to be applied over payment total value
     */
    public float $value;
    /**
     * Days before due date to apply discount.
     * @var int "0 = until due date, 1 = until one day before, 2 = until two days before, and so on"
     */
    public int $dueDateLimitDays;
    /**
     * @var string "FIXED or PERCENTAGE"
     */
    public string $type;
}
