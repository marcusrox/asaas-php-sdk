<?php
namespace Adrianovcar\Asaas\Api;

// Entities
use Adrianovcar\Asaas\Entity\Payment as PaymentEntity;
use Adrianovcar\Asaas\Exception\AsaasApiException;

/**
 * Payment API Endpoint
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class Payment extends \Adrianovcar\Asaas\Api\AbstractApi
{
    /**
     * Get all payments
     *
     * @param   array  $filters  (optional) Filters Array
     * @return  array  Payments Array
     *
     * @throws \Exception
     */
    public function getAll(array $filters = [])
    {
        try {
            $payments = $this->adapter->get(sprintf('%s/payments?%s', $this->endpoint, http_build_query($filters)));
            $payments = json_decode($payments);
            $this->extractMeta($payments);

            return array_map(function ($payment) {
                return new PaymentEntity($payment);
            }, $payments->data);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get Payment By Id
     *
     * @param   int  $id  Payment Id
     * @return  PaymentEntity
     *
     * @throws \Exception
     */
    public function getById($id)
    {
        try {
            $payment = $this->adapter->get(sprintf('%s/payments/%s', $this->endpoint, $id));
            $payment = json_decode($payment);

            return new PaymentEntity($payment);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get Payments By Customer Id
     *
     * @param   int    $customerId  Customer Id
     * @param   array  $filters     (optional) Filters Array
     * @return  PaymentEntity[]
     *
     * @throws \Exception
     */
    public function getByCustomer($customerId, array $filters = [])
    {
        try {
            $payments = $this->adapter->get(sprintf('%s/customers/%s/payments?%s', $this->endpoint, $customerId, http_build_query($filters)));
            $payments = json_decode($payments);
            $this->extractMeta($payments);

            return array_map(function ($payment) {
                return new PaymentEntity($payment);
            }, $payments->data);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get Payments By Subscription Id
     *
     * @param   int    $subscriptionId  Subscription Id
     * @param   array  $filters         (optional) Filters Array

     * @return  PaymentEntity[]|string
     *
     * @throws \Exception
     */
    public function getBySubscription($subscriptionId)
    {
        try {
            $payments = $this->adapter->get(sprintf('%s/subscriptions/%s/payments?%s', $this->endpoint, $subscriptionId, http_build_query($filters)));
            $payments = json_decode($payments);
            $this->extractMeta($payments);

            return array_map(function ($payment) {
                return new PaymentEntity($payment);
            }, $payments->data);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Create New Payment
     *
     * @param array $data Payment Data
     * @return  PaymentEntity|string
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            $payment = $this->adapter->post(sprintf('%s/payments', $this->endpoint), $data);
            $payment = json_decode($payment);

            return new PaymentEntity($payment);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Update Payment By Id
     *
     * @param   string  $id    Payment Id
     * @param   array   $data  Payment Data
     * @return  PaymentEntity|string
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        try {
            $payment = $this->adapter->post(sprintf('%s/payments/%s', $this->endpoint, $id), $data);
            $payment = json_decode($payment);

            return new PaymentEntity($payment);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Delete Payment By Id
     *
     * @param  string|int  $id  Payment Id
     * @throws \Exception
     *
     */
    public function delete($id)
    {
        try{
            $this->adapter->delete(sprintf('%s/payments/%s', $this->endpoint, $id));
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }
}
