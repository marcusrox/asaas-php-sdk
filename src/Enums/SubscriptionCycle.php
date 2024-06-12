<?php

namespace Adrianovcar\Asaas\Enums;

enum SubscriptionCycle: string
{
    case WEEKLY = 'WEEKLY';
    case BIWEEKLY = 'BIWEEKLY';
    case MONTHLY = 'MONTHLY';
    case BIMONTHLY = 'BIMONTHLY';
    case QUARTERLY = 'QUARTERLY';
    case SEMIANNUALLY = 'SEMIANNUALLY';
    case YEARLY = 'YEARLY';

    /**
     *  Get the number of days by the given cycle
     *
     * @param  string  $cycle
     * @return int
     */
    public static function getDays(string $cycle): int
    {
        return match ($cycle) {
            self::WEEKLY->value => 7,
            self::BIWEEKLY->value => 14,
            self::MONTHLY->value => 30,
            self::BIMONTHLY->value => 60,
            self::QUARTERLY->value => 90,
            self::SEMIANNUALLY->value => 180,
            self::YEARLY->value => 365,
            default => 1,
        };
    }
}
