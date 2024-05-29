<?php

namespace Adrianovcar\Asaas\Api;

use Adrianovcar\Asaas\Adapter\AdapterInterface;
use Adrianovcar\Asaas\Entity\Meta;
use Exception;
use StdClass;

/**
 * Abstract API
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 */
abstract class AbstractApi
{
    /**
     * Endpoint Produção
     *
     * @var string
     */
    const PRODUCTION_ENDPOINT = 'https://www.asaas.com/api/v3';

    /**
     * Endpoint Sandbox
     *
     * @var string
     */
    const SANDBOX_ENDPOINT = 'https://sandbox.asaas.com/api/v3';

    /**
     * Http Adapter Instance
     *
     * @var AdapterInterface
     */
    protected AdapterInterface $adapter;

    /**
     * Api Endpoint
     *
     * @var string
     */
    protected string $endpoint;

    /**
     * @var Meta
     */
    protected Meta $meta;

    /**
     * Constructor
     *
     * @param  AdapterInterface  $adapter  Adapter Instance
     * @param  string  $ambiente  (optional) Ambiente da API
     */
    public function __construct(AdapterInterface $adapter, string $ambiente = 'production')
    {
        $this->adapter = $adapter;

        switch ($ambiente) {
            case 'production':
                $this->endpoint = static::PRODUCTION_ENDPOINT;
                break;
            default:
                $this->endpoint = static::SANDBOX_ENDPOINT;
        }
    }

    /**
     * Return results meta
     *
     * @return  Meta
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * @throws Exception
     */
    public function dispatchException(Exception $exception)
    {
        throw new Exception($exception->getMessage(), $exception->getCode());
    }

    /**
     * Extract results meta
     *
     * @param  stdClass  $data  Meta data
     * @return  Meta
     */
    protected function extractMeta(StdClass $data): Meta
    {
        $this->meta = new Meta($data);

        return $this->meta;
    }
}
