<?php

namespace Adrianovcar\Asaas\Api;

use Adrianovcar\Asaas\Entity\Payment as PaymentEntity;
use Exception;

/**
 * Payment API Endpoint
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class Payment extends AbstractApi
{
    /**
     * Get all payments
     *
     * @param  array  $filters  (optional) Filters Array
     * @return  array  Payments Array
     *
     * @throws Exception
     */
    public function getAll(array $filters = []): array
    {
        try {
            $payments = $this->adapter->get(sprintf('%s/payments?%s', $this->endpoint, http_build_query($filters)));
            $payments = json_decode($payments);
            $this->extractMeta($payments);

            return array_map(function ($payment) {
                return new PaymentEntity($payment);
            }, $payments->data);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get Payment By ID
     *
     * @param  string  $id  Payment ID
     * @return  PaymentEntity
     *
     * @throws Exception
     */
    public function getById(string $id): PaymentEntity
    {
        try {
            $payment = $this->adapter->get(sprintf('%s/payments/%s', $this->endpoint, $id));
            $payment = json_decode($payment);

            return new PaymentEntity($payment);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get Payments By Customer ID
     *
     * @param  string  $customerId  Customer ID
     * @param  array  $filters  (optional) Filters Array
     * @return  PaymentEntity[]
     *
     * @throws Exception
     */
    public function getByCustomer(string $customerId, array $filters = []): array
    {
        try {
            $payments = $this->adapter->get(sprintf('%s/customers/%s/payments?%s', $this->endpoint, $customerId, http_build_query($filters)));
            $payments = json_decode($payments);
            $this->extractMeta($payments);

            return array_map(function ($payment) {
                return new PaymentEntity($payment);
            }, $payments->data);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get Payments By Subscription ID
     *
     * @param  string  $subscriptionId  Subscription ID
     * @param  array  $filters  (optional) Filters Array
     * @return  PaymentEntity[]
     *
     * @throws Exception
     */
    public function getBySubscription(string $subscriptionId, array $filters): array
    {
        try {
            $payments = $this->adapter->get(sprintf('%s/subscriptions/%s/payments?%s', $this->endpoint, $subscriptionId, http_build_query($filters)));
            $payments = json_decode($payments);
            $this->extractMeta($payments);

            return array_map(function ($payment) {
                return new PaymentEntity($payment);
            }, $payments->data);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Create New Payment
     *
     * @param  PaymentEntity  $payment
     * @return  PaymentEntity
     * @throws Exception
     */
    public function create(PaymentEntity $payment): PaymentEntity
    {
        try {
            $payment = $this->adapter->post(sprintf('%s/payments', $this->endpoint), $payment->toArray());
            $payment = json_decode($payment);

            return new PaymentEntity($payment);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Create a new PIX QRCODE for a given payment
     *
     * @param  string  $payment_id  Asaas Payment ID
     * @return array
     * @throws Exception
     */
    public function qrCode(string $payment_id): array
    {
        try {
            $result = $this->adapter->get(sprintf('%s/payments/%s/pixQrCode', $this->endpoint, $payment_id));

            return json_decode($result, true);
        } catch (Exception $e) {
            return $this->dispatchException($e);
        }
    }

    /**
     * Update Payment By ID
     *
     * @param  string  $id  Payment ID
     * @param  array  $data  Payment Data
     * @return  PaymentEntity
     * @throws Exception
     */
    public function update(string $id, array $data): PaymentEntity
    {
        try {
            $payment = $this->adapter->post(sprintf('%s/payments/%s', $this->endpoint, $id), $data);
            $payment = json_decode($payment);

            return new PaymentEntity($payment);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Delete Payment By ID
     *
     * @param  string|int  $id  Payment ID
     * @throws Exception
     *
     */
    public function delete($id)
    {
        try {
            $this->adapter->delete(sprintf('%s/payments/%s', $this->endpoint, $id));
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }
}
