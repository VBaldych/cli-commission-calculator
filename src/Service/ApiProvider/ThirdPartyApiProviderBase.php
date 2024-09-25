<?php

declare(strict_types=1);

namespace App\Service\ApiProvider;

abstract class ThirdPartyApiProviderBase
{
    public function getConnection(string $url): array {
        $response = file_get_contents($url);

        if (!$response) {
            throw new \RuntimeException("Error: can't recieve data by URL " . $url);
        }

        return json_decode($response, true) ?? throw new \RuntimeException("Error: not found data by URL " . $url);
    }
}