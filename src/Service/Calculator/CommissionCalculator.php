<?php

declare(strict_types=1);

namespace App\Service\Calculator;

use App\Service\ApiProvider\BinListProvider;
use App\Service\ApiProvider\ExchangeRateProvider;
use App\Service\EuCountriesProvider;

class CommissionCalculator
{
    private const EU_RATE = 0.01;
    private const NON_EU_RATE = 0.02;
    private const DEFAULT_CURRENCY = 'EUR';

    public function __construct(
        private readonly BinListProvider $binListProvider,
        private readonly ExchangeRateProvider $exchangeRateProvider,
        private readonly EuCountriesProvider $euCountriesProvider
    ) { }

    public function calculate(int $bin, float $amount, string $currency): float
    {
        $country = $this->binListProvider
            ->getCountryByBin($bin);

        $rate = $this->exchangeRateProvider
            ->getCurrencyRate($currency);

        $isEu = $this->euCountriesProvider
            ->isEuCountry($country);

        $commissionRate = $isEu ? self::EU_RATE : self::NON_EU_RATE;
        
        $amountFixed = ($currency === self::DEFAULT_CURRENCY || $rate === 0) ? $amount : $amount / $rate;

        // Return value with rounded cents (like 0.47).
        return round($amountFixed * $commissionRate, 2);
    }
}