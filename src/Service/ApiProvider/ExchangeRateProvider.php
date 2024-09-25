<?php

declare(strict_types=1);

namespace App\Service\ApiProvider;

use App\Service\ApiProvider\ThirdPartyApiProviderBase;

final class ExchangeRateProvider extends ThirdPartyApiProviderBase
{
    private const API_KEY = '3d3348f642ad9981b97df049aec70c9c';
    private const EXCHANGE_RATE_URL = 'https://api.exchangeratesapi.io/latest?access_key=' . self::API_KEY;
    private const SUCCESS_STATUS = true;

    public function getCurrencyRate(string $currency): float
    {
        $data = $this->getConnection(self::EXCHANGE_RATE_URL);

        if ($data['success'] !== self::SUCCESS_STATUS) {
            throw new \RuntimeException("Error: can't recieve data from Exchange Rate API, please check your API key");
        }

        return $data['rates'][$currency]
            ?? throw new \RuntimeException('Error: currency ' . $currency . ' not found, please check it in input file');
    }
}
