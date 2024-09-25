<?php

declare(strict_types=1);

namespace App\Service\ApiProvider;

use App\Service\ApiProvider\ThirdPartyApiProviderBase;

class BinListProvider extends ThirdPartyApiProviderBase
{
    private const BIN_LIST_URL = 'https://data.handyapi.com/bin/';
    private const SUCCESS_STATUS = 'SUCCESS';

    public function getCountryByBin(int $bin): string
    {
        $data = $this->getConnection(self::BIN_LIST_URL . $bin);

        if ($data['Status'] !== self::SUCCESS_STATUS) {
            throw new \RuntimeException('Error: not found data for BIN ' . $bin);
        }

        return $data['Country']['A2'];
    }
}
