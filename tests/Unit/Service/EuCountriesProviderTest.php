<?php

declare(strict_types= 1);

namespace App\Tests\Unit\Service;

use App\Service\EuCountriesProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EuCountriesProviderTest extends TestCase
{    
    private EuCountriesProvider $euCountriesProvider;

    protected function setUp(): void
    {
        $this->euCountriesProvider = new EuCountriesProvider();
    }

    #[DataProvider('countriesDataProvider')]
    public function testCountries(string $country, bool $value): void
    {
        $this->assertSame($value, $this->euCountriesProvider->isEuCountry($country));
    }

    public static function countriesDataProvider(): array
    {
        return [
            ['GR', true],
            ['GB', false],
            ['SK', true],
            ['UA', false],
        ];
    }
}