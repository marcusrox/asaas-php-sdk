<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * City Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class City extends AbstractEntity
{
    public int $id;
    public int $ibgeCode;
    public string $name;
    public int $districtCode;
    public string $district;
    public string $state;
}
