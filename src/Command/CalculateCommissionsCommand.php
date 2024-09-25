<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\Calculator\CommissionCalculator;
use App\Service\ApiProvider\BinListProvider;
use App\Service\ApiProvider\ExchangeRateProvider;
use App\Service\EuCountriesProvider;

class CalculateCommissionsCommand
{
    private const REQUIRED_KEYS = [
        'bin',
        'amount',
        'currency',
    ];

    private readonly CommissionCalculator $commissionCalculator;

    public function __construct()
    { 
        $this->commissionCalculator = new CommissionCalculator(
            new BinListProvider(),
            new ExchangeRateProvider(),
            new EuCountriesProvider()
        );
    }

    public function execute($argv): void
    {
        // Get path to data file from CLI input.
        $filePath = $argv[1];

        if ($filePath === null) {
            throw new \RuntimeException('Input path is required' . PHP_EOL);
        }

        $this->processFile($filePath);
    }

    private function processFile(string $filePath): void {
        $fileContent = new \SplFileObject($filePath);

        while(!$fileContent->eof()) {
            $this->processLine($fileContent);
        }
    }

    private function processLine(\SplFileObject $fileContent): void {
        $line = trim($fileContent->fgets());

        if (trim($line) === '') {
            return;
        }
        
        try {
            $transaction = json_decode($line, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('JSON parsing error: invalid string on line ' . $fileContent->key());
            }

            // Check if all keys exists in JSON line.
            $missingKeys = array_diff_key(array_flip(self::REQUIRED_KEYS), $transaction);

            if (count($missingKeys) > 0) {
                $missingKeys = implode(', ', array_keys($missingKeys));
 
                throw new \RuntimeException('JSON parsing error: missing keys ' . $missingKeys . ' on line ' . $fileContent->key());
            }

            $bin = (int) $transaction['bin'];
            $amount = (float) $transaction['amount'];
            $currency = $transaction['currency'];
 
            $commission = $this->commissionCalculator
                ->calculate($bin, $amount, $currency);
            
            echo $commission . PHP_EOL;
        }
        catch (\RuntimeException $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}