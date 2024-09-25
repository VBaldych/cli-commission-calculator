<?php

declare(strict_types= 1);

namespace App\Tests\Unit\Service\Calculator;

use App\Service\ApiProvider\BinListProvider;
use App\Service\ApiProvider\ExchangeRateProvider;
use App\Service\Calculator\CommissionCalculator;
use App\Service\EuCountriesProvider;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    public function testCalculatorResultEu(): void
    {
        $binListProviderStub = $this->createStub(BinListProvider::class);
        $binListProviderStub->method('getCountryByBin')->willReturn('DK');

        $exchangeRateProviderStub = $this->createStub(ExchangeRateProvider::class);
        $exchangeRateProviderStub->method('getCurrencyRate')->willReturn(1.00);
        
        $euCountriesProviderStub = $this->createStub(EuCountriesProvider::class);
        $euCountriesProviderStub->method('isEuCountry')->willReturn(true);

        $calculator = new CommissionCalculator(
            $binListProviderStub,
            $exchangeRateProviderStub,
            $euCountriesProviderStub
        );

        $commission = $calculator->calculate(45717360, 100.00, 'EUR');
        $this->assertEquals(1.00, $commission);
    }

    public function testCalculatorResultNonEu(): void
    {
        $binListProviderStub = $this->createStub(BinListProvider::class);
        $binListProviderStub->method('getCountryByBin')->willReturn('GB');

        $exchangeRateProviderStub = $this->createStub(ExchangeRateProvider::class);
        $exchangeRateProviderStub->method('getCurrencyRate')->willReturn(0.852511);
        
        $euCountriesProviderStub = $this->createStub(EuCountriesProvider::class);
        $euCountriesProviderStub->method('isEuCountry')->willReturn(false);

        $calculator = new CommissionCalculator(
            $binListProviderStub,
            $exchangeRateProviderStub,
            $euCountriesProviderStub
        );

        $commission = $calculator->calculate(4745030, 2000.00, 'GBP');
        $this->assertEquals(46.92, $commission);
    }
}