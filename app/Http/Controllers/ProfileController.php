<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repository\TransactionsRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use function App\Helpers\getAuthUser;

final class ProfileController extends Controller
{
    public function __construct(
        private readonly TransactionsRepositoryInterface $transactionRepo
    )
    {}

    /**
     * @throws \Exception
     */
    public function profile(): View|Application|Factory
    {
        $user = getAuthUser();
        $isPaid = $this->transactionRepo->getUserPaidStatus($user->id);
        return view('profile',compact('user','isPaid'));
    }
}
