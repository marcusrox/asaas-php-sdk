<?php

namespace Adrianovcar\Asaas\Api;

use Exception;

/**
 * Payment API Endpoint
 *
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class PixQrCode extends AbstractApi
{
    /**
     * Create a new Static PIX QR CODE
     *
     * @param string $addressKey Chave que receberá os pagamentos do QrCode
     * @param string $description Descrição do QrCode
     * @param float $value Valor do QrCode, caso não informado o pagador poderá escolher o valor
     *
     * @return string
     *
     * @throws Exception
     */
    public function create(string $addressKey, string $description, float $value): string
    {
        $data = [
            "addressKey" => $addressKey,
            "description" => $description,
            "value" => $value,
        ];

        try {
            return $this->adapter->post(sprintf('%s/pix/qrCodes/static', $this->endpoint), $data);
        } catch (Exception $e) {
            return $this->dispatchException($e);
        }
    }
}
