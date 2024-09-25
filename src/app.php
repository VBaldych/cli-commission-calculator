<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Command\CalculateCommissionsCommand;

$transactionProcessor = new CalculateCommissionsCommand();
$transactionProcessor->execute($argv);