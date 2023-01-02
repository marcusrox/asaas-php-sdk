<?php

namespace Adrianovcar\Asaas\Api;

use Adrianovcar\Asaas\Entity\Customer as CustomerEntity;
use Exception;

/**
 * Payment API Endpoint
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class PixKey extends AbstractApi
{
    /**
     * Create new Pix Key
     * Keys are needed to create a new Pix payment
     *
     * @return  string
     *
     * @throws Exception
     */
    public function create(): string
    {
        try {
            return $this->adapter->post(sprintf('%s/pix/addressKeys', $this->endpoint), ["type" => "EVP"]);
        } catch (Exception $e) {
            $this->dispatchException($e);
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
     *
     * @throws Exception
     */
    public function getAll(array $filters = []): array
    {
        try {
            $customers = $this->adapter->get(sprintf('%s/pix/addressKeys?%s', $this->endpoint, http_build_query($filters)));

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
     * Get key by ID
     * Keys are needed to create a new Pix payment
     *
     * @param $id
     * @return  string
     *
     * @throws Exception
     */
    public function getById($id): string
    {
        try {
            return $this->adapter->get(sprintf('%s/pix/addressKeys/%s', $this->endpoint, $id));
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Delete key by ID
     *
     * @param $id
     * @return  string
     *
     * @throws Exception
     */
    public function delete($id): string
    {
        try {
            return $this->adapter->delete(sprintf('%s/pix/addressKeys/%s', $this->endpoint, $id));
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }
}
