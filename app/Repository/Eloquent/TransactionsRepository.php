<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\TransactionsRepositoryInterface;

class TransactionsRepository implements TransactionsRepositoryInterface
{
    public function getUserPaidStatus(int $userId): bool
    {
        // For now, just check if the user has a paid status
        // In a real application, you might check a transactions table
        $user = User::find($userId);
        return $user && !empty($user->paid_status);
    }
}