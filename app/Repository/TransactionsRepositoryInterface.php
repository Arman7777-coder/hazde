<?php

declare(strict_types=1);

namespace App\Repository;

interface TransactionsRepositoryInterface
{
    public function getUserPaidStatus(int $userId): bool;
}