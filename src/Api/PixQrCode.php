<?php

namespace Adrianovcar\Asaas\Api;

use Adrianovcar\Asaas\Exception\HttpException;

/**
 * Payment API Endpoint
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class PixQrCode extends \Adrianovcar\Asaas\Api\AbstractApi
{
    /**
     * Create a new Static PIX QR CODE
     *
     * @param string $addressKey Chave que receberá os pagamentos do QrCode
     * @param string $description Descrição do QrCode
     * @param float $value Valor do QrCode, caso não informado o pagador poderá escolher o valor
     *
     * @return string
     */
    public function create($addressKey, $description, $value)
    {
        $data = [
            "addressKey" => $addressKey,
            "description" => $description,
            "value" => $value,
        ];

        try {
            return $this->adapter->post(sprintf('%s/pix/qrCodes/static', $this->endpoint), $data);
        } catch (HttpException $e) {
            return $e->getMessage();
        }
    }
}
