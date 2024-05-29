<?php

namespace Adrianovcar\Asaas\Adapter;

use Adrianovcar\Asaas\Exception\HttpException;

/**
 * Adapter Http Interface
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
interface AdapterInterface
{
    /**
     * GET Request
     *
     * @param  string  $url  Request Url
     * @return  string
     * @throws  HttpException
     */
    public function get(string $url): string;

    /**
     * DELETE Request
     *
     * @param  string  $url  Request Url
     * @throws  HttpException
     */
    public function delete(string $url): string;

    /**
     * PUT Request
     *
     * @param  string  $url  Request Url
     * @param  mixed  $content  Request Content
     * @return  string
     * @throws  HttpException
     */
    public function put(string $url, $content = ''): string;

    /**
     * POST Request
     *
     * @param  string  $url  Request Url
     * @param  mixed  $content  Request Content
     * @return  string
     * @throws  HttpException
     */
    public function post(string $url, $content = ''): string;

    /**
     * Get last response headers
     *
     * @return array|null
     */
    public function getLatestResponseHeaders(): ?array;
}
