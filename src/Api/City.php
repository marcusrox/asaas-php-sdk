<?php

namespace Adrianovcar\Asaas\Api;

use Adrianovcar\Asaas\Entity\City as CityEntity;
use Exception;

/**
 * City API Endpoint
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class City extends AbstractApi
{
    /**
     * Get all cities
     *
     * @param  array  $filters  (optional) Filters Array
     * @return  array  Cities Array
     *
     * @throws Exception
     */
    public function getAll(array $filters = []): array
    {
        try {
            $cities = $this->adapter->get(sprintf('%s/cities?%s', $this->endpoint, http_build_query($filters)));
            $cities = json_decode($cities);
            $this->extractMeta($cities);

            return array_map(function ($city) {
                return new CityEntity($city);
            }, $cities->data);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }

    /**
     * Get City By ID
     *
     * @param  int  $id  City ID
     * @return CityEntity
     *
     * @throws Exception
     */
    public function getById(int $id): CityEntity
    {
        try {
            $city = $this->adapter->get(sprintf('%s/cities/%s', $this->endpoint, $id));
            $city = json_decode($city);

            return new CityEntity($city);
        } catch (Exception $e) {
            $this->dispatchException($e);
        }
    }
}
