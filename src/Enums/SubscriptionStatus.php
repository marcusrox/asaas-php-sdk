<?php

namespace Adrianovcar\Asaas\Enums;

enum SubscriptionStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case EXPIRED = 'EXPIRED';
}
