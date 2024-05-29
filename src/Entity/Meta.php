<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Base Meta Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Meta extends AbstractEntity
{
    public int $limit;
    public int $offset;
    public bool $hasMore;
}
