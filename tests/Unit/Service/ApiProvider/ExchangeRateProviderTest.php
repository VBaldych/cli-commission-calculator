<?php

declare(strict_types= 1);

namespace App\Tests\Unit\Service\ApiProvider;

use App\Service\ApiProvider\ExchangeRateProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ExchangeRateProviderTest extends TestCase
{
    private MockObject $providerMock;

    protected function setUp(): void
    {
        $this->providerMock = $this->getMockBuilder(ExchangeRateProvider::class)
            ->onlyMethods(['getConnection'])
            ->getMock();
    }
    
    public function testGetCurrencyRateSuccess(): void
    {
        $this->providerMock
            ->method('getConnection')
            ->willReturn([
                'success' => true,
                'base' => 'EUR',
                'rates' => [
                    'DKK' => 7.465485,
                    'EUR' => 1,
                    'JPY' => 162.862308,
                    'USD' => 1.103448,
                ],
            ],
        );

        $this->assertEquals(7.465485, $this->providerMock->getCurrencyRate('DKK'));
        $this->assertEquals(1, $this->providerMock->getCurrencyRate('EUR'));
        $this->assertEquals(162.862308, $this->providerMock->getCurrencyRate('JPY'));
        $this->assertEquals(1.103448, $this->providerMock->getCurrencyRate('USD'));
    }

    public function testGetCurrencyRateFailure(): void
    {
        $this->providerMock
            ->expects($this->once())
            ->method('getConnection')
            ->will($this->throwException(new \RuntimeException('Error retrieving exchange rates.')));

        $this->expectException(\RuntimeException::class);

        $this->providerMock->getCurrencyRate('USD');
    }
}
