<?php

namespace Adrianovcar\Asaas;


// API's
use Adrianovcar\Asaas\Adapter\AdapterInterface;
use Adrianovcar\Asaas\Api\City;
use Adrianovcar\Asaas\Api\Customer;
use Adrianovcar\Asaas\Api\Notification;
use Adrianovcar\Asaas\Api\Payment;
use Adrianovcar\Asaas\Api\Pix;
use Adrianovcar\Asaas\Api\PixKey;
use Adrianovcar\Asaas\Api\PixQrCode;
use Adrianovcar\Asaas\Api\Subscription;


/**
 * Asass API Wrapper
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class Asaas
{
    /**
     * Adapter Interface
     *
     * @var  AdapterInterface
     */
    protected $adapter;

    /**
     * Ambiente da API
     *
     * @var  string
     */
    protected $ambiente;

    /**
     * Constructor
     *
     * @param AdapterInterface $adapter Adapter Instance
     * @param string $ambiente (optional) Ambiente da API
     */
    public function __construct(AdapterInterface $adapter, $ambiente = 'producao')
    {
        $this->adapter = $adapter;

        $this->ambiente = $ambiente;
    }

    /**
     * Get customer endpoint
     *
     * @return  Customer
     */
    public function customer(): Customer
    {
        return new Customer($this->adapter, $this->ambiente);
    }

    /**
     * Get subscription endpoint
     *
     * @return  Subscription
     */
    public function subscription()
    {
        return new Subscription($this->adapter, $this->ambiente);
    }

    /**
     * Get payment endpoint
     *
     * @return  Payment
     */
    public function payment()
    {
        return new Payment($this->adapter, $this->ambiente);
    }

    /**
     * Get Notification API Endpoint
     *
     * @return  Notification
     */
    public function notification()
    {
        return new Notification($this->adapter, $this->ambiente);
    }

    /**
     * Get city endpoint
     *
     * @return  City
     */
    public function city()
    {
        return new City($this->adapter, $this->ambiente);
    }

    public function pixKey()
    {
        return new PixKey($this->adapter, $this->ambiente);
    }

    public function pixQrCode()
    {
        return new PixQrCode($this->adapter, $this->ambiente);
    }
}
