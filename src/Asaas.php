<?php

namespace Adrianovcar\Asaas;

use Adrianovcar\Asaas\Adapter\AdapterInterface;
use Adrianovcar\Asaas\Api\City;
use Adrianovcar\Asaas\Api\Customer;
use Adrianovcar\Asaas\Api\Notification;
use Adrianovcar\Asaas\Api\Payment;
use Adrianovcar\Asaas\Api\PixKey;
use Adrianovcar\Asaas\Api\PixQrCode;
use Adrianovcar\Asaas\Api\Subscription;


/**
 * Asass API Wrapper
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class Asaas
{
    /**
     * Adapter Interface
     *
     * @var  AdapterInterface
     */
    protected AdapterInterface $adapter;

    /**
     * Ambiente da API
     *
     * @var  string
     */
    protected string $ambiente;

    /**
     * Constructor
     *
     * @param AdapterInterface $adapter Adapter Instance
     * @param string $environment (optional) api environment
     */
    public function __construct(AdapterInterface $adapter, string $environment = 'production')
    {
        $this->adapter = $adapter;
        $this->ambiente = $environment;
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
    public function subscription(): Subscription
    {
        return new Subscription($this->adapter, $this->ambiente);
    }

    /**
     * Get payment endpoint
     *
     * @return  Payment
     */
    public function payment(): Payment
    {
        return new Payment($this->adapter, $this->ambiente);
    }

    /**
     * Get Notification API Endpoint
     *
     * @return  Notification
     */
    public function notification(): Notification
    {
        return new Notification($this->adapter, $this->ambiente);
    }

    /**
     * Get city endpoint
     *
     * @return  City
     */
    public function city(): City
    {
        return new City($this->adapter, $this->ambiente);
    }

    /**
     * Get Pix key code
     *
     * @return  PixKey
     */
    public function pixKey(): PixKey
    {
        return new PixKey($this->adapter, $this->ambiente);
    }

    /**
     * Get Pix QrCode
     *
     * @return  PixQrCode
     */
    public function pixQrCode(): PixQrCode
    {
        return new PixQrCode($this->adapter, $this->ambiente);
    }
}
