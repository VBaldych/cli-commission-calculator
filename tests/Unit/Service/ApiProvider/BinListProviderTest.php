<?php

declare(strict_types= 1);

namespace App\Tests\Unit\Service\ApiProvider;

use App\Service\ApiProvider\BinListProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BinListProviderTest extends TestCase
{
    private MockObject $providerMock;

    protected function setUp(): void
    {
        $this->providerMock = $this->getMockBuilder(BinListProvider::class)
            ->onlyMethods(['getConnection'])
            ->getMock();
    }
    
    public function testGetCountryByBinSuccess(): void
    {
        $this->providerMock
            ->method('getConnection')
            ->willReturn([
                'Status' => 'SUCCESS',
                'CardTier' => 'DANKORT',
                'Country' => [
                    'A2' => 'DK',
                ],
            ]);

        $countryCode = $this->providerMock->getCountryByBin(45717360);

        $this->assertEquals('DK', $countryCode);
    }

    public function testGetCountryByBinFailure(): void
    {
        $this->providerMock->expects($this->once())
            ->method('getConnection')
            ->will($this->throwException(new \RuntimeException('Error retrieving BIN information.')));

        $this->expectException(\RuntimeException::class);

        $this->providerMock->getCountryByBin(45717360);
    }
}
