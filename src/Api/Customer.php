<?php

namespace Adrianovcar\Asaas\Api;

use Adrianovcar\Asaas\Entity\Customer as CustomerEntity;
use Exception;

/**
 * Customer API Endpoint
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class Customer extends AbstractApi
{
    /**
     * Get Customer By ID
     *
     * @param  string  $id  Customer ID
     * @return  CustomerEntity
     *
     * @throws Exception
     */
    public function getById(string $id): CustomerEntity
    {
        try {
            $customer = $this->adapter->get(sprintf('%s/customers/%s', $this->endpoint, $id));
            $customer = json_decode($customer);

            return new CustomerEntity($customer);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get Customer By Email
     *
     * @param  string  $email  Customer Id
     * @return  CustomerEntity
     * @throws Exception
     */
    public function getByEmail($email): CustomerEntity
    {
        foreach ($this->getAll(['name' => $email]) as $customer) {
            if ($customer->email == $email) {
                return $customer;
            }
        }

        return new CustomerEntity();
    }

    /**
     * Get all customers
     *
     * @param  array  $filters  (optional) Filters Array
     * @return  array  Customers Array
     *
     * @throws Exception
     */
    public function getAll(array $filters = []): array
    {
        try {
            $customers = $this->adapter->get(sprintf('%s/customers?%s', $this->endpoint, http_build_query($filters)));
            $customers = json_decode($customers);
            $this->extractMeta($customers);

            return array_map(function ($customer) {
                return new CustomerEntity($customer);
            }, $customers->data);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Create new customer
     *
     * @param  array  $data  Customer Data
     * @return  CustomerEntity
     *
     * @throws Exception
     */
    public function create(array $data): CustomerEntity
    {
        try {
            $customer = $this->adapter->post(sprintf('%s/customers', $this->endpoint), $data);
            $customer = json_decode($customer);

            return new CustomerEntity($customer);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Update Customer By Id
     *
     * @param  string  $id  Customer Id
     * @param  array  $data  Customer Data
     * @return  CustomerEntity
     */
    public function update(string $id, array $data): CustomerEntity
    {
        try {
            $customer = $this->adapter->post(sprintf('%s/customers/%s', $this->endpoint, $id), $data);
            $customer = json_decode($customer);

            return new CustomerEntity($customer);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Delete Customer By Id
     *
     * @param  string  $id  Customer ID
     * @throws Exception
     */
    public function delete(string $id)
    {
        try {
            $this->adapter->delete(sprintf('%s/customers/%s', $this->endpoint, $id));
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }
}
