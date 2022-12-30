<?php
namespace Adrianovcar\Asaas\Entity;

/**
 * Base Meta Entity
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Meta extends \Adrianovcar\Asaas\Entity\AbstractEntity
{
    /**
     * @var int
     */
    public $limit;

    /**
     * @var int
     */
    public $offset;

    /**
     * @var boolean
     */
    public $hasMore;
}
