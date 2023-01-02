<?php
namespace Adrianovcar\Asaas\Api;

// Entities
use Adrianovcar\Asaas\Entity\Customer as CustomerEntity;

/**
 * Customer API Endpoint
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class Customer extends \Adrianovcar\Asaas\Api\AbstractApi
{
    /**
     * Get all customers
     *
     * @param   array  $filters  (optional) Filters Array
     * @return  array  Customers Array
     *
     * @throws \Exception
     */
    public function getAll(array $filters = [])
    {
        try{
            $customers = $this->adapter->get(sprintf('%s/customers?%s', $this->endpoint, http_build_query($filters)));
            $customers = json_decode($customers);
            $this->extractMeta($customers);

            return array_map(function ($customer) {
                return new CustomerEntity($customer);
            }, $customers->data);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get Customer By ID
     *
     * @param string $id  Customer ID
     * @return  CustomerEntity
     *
     * @throws \Exception
     */
    public function getById(string $id): CustomerEntity
    {
        try{
            $customer = $this->adapter->get(sprintf('%s/customers/%s', $this->endpoint, $id));
            $customer = json_decode($customer);

            return new CustomerEntity($customer);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get Customer By Email
     *
     * @param   string  $email  Customer Id
     * @return  CustomerEntity
     */
    public function getByEmail($email)
    {
        foreach ($this->getAll(['name' => $email]) as $customer) {
            if ($customer->email == $email) {
                return $customer;
            }
        }

        return;
    }

    /**
     * Create new customer
     *
     * @param   array  $data  Customer Data
     * @return  CustomerEntity
     *
     * @throws \Exception
     */
    public function create(array $data)
    {
        try{
            $customer = $this->adapter->post(sprintf('%s/customers', $this->endpoint), $data);
            $customer = json_decode($customer);

            return new CustomerEntity($customer);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Update Customer By Id
     *
     * @param   string  $id    Customer Id
     * @param   array   $data  Customer Data
     * @return  CustomerEntity
     */
    public function update($id, array $data)
    {
        try{
            $customer = $this->adapter->post(sprintf('%s/customers/%s', $this->endpoint, $id), $data);
            $customer = json_decode($customer);

            return new CustomerEntity($customer);
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Delete Customer By Id
     *
     * @param  string  $id  Customer ID
     * @throws \Exception
     */
    public function delete($id)
    {
        try{
            $this->adapter->delete(sprintf('%s/customers/%s', $this->endpoint, $id));
        } catch (\Exception $e) {
            $this->dispatchException($e);
        }
    }
}
