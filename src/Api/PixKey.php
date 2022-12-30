<?php

namespace Adrianovcar\Asaas\Api;

use Adrianovcar\Asaas\Entity\Customer as CustomerEntity;
use Adrianovcar\Asaas\Exception\HttpException;

/**
 * Payment API Endpoint
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class PixKey extends \Adrianovcar\Asaas\Api\AbstractApi
{
    /**
     * Create new Pix Key
     * Keys are needed to create a new Pix payment
     *
     * @return  string
     */
    public function create()
    {
        try {
            return $this->adapter->post(sprintf('%s/pix/addressKeys', $this->endpoint), ["type" => "EVP"]);
        } catch (HttpException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get all keys
     *
     * status (string) Filtrar pelo status atual da chave
     * statusList (string) Filtrar por um ou mais status das chaves
     * offset (int) Elemento inicial da lista
     * limit (number) Número de elementos da lista (max: 100)
     *
     * @param array $filters (optional) Filters Array
     * @return  array  Customers Array
     */
    public function getAll(array $filters = [])
    {
        try {
            $customers = $this->adapter->get(sprintf('%s/pix/addressKeys?%s', $this->endpoint, http_build_query($filters)));

            $customers = json_decode($customers);

            $this->extractMeta($customers);

            return array_map(function ($customer) {
                return new CustomerEntity($customer);
            }, $customers->data);
        } catch (HttpException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get key by ID
     * Keys are needed to create a new Pix payment
     *
     * @return  string
     */
    public function getById($id)
    {
        try {
            return $this->adapter->get(sprintf('%s/pix/addressKeys/%s', $this->endpoint, $id));
        } catch (HttpException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Delete key by ID
     *
     * @return  string
     */
    public function delete($id)
    {
        try {
            return $this->adapter->delete(sprintf('%s/pix/addressKeys/%s', $this->endpoint, $id));
        } catch (HttpException $e) {
            return $e->getMessage();
        }
    }
}
