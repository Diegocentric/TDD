<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function create()
    {
        $account = $this->accountService->createAccount();
        return response()->json($account);
    }

    public function deposit(Request $request, Account $account)
    {
        $amount = $request->input('amount');
        $success = $this->accountService->deposit($account, $amount);
        return response()->json(['success' => $success, 'balance' => $account->balance]);
    }

    public function withdraw(Request $request, Account $account)
    {
        $amount = $request->input('amount');
        $success = $this->accountService->withdraw($account, $amount);
        return response()->json(['success' => $success, 'balance' => $account->balance]);
    }

    public function transfer(Request $request, Account $fromAccount, Account $toAccount)
    {
        $amount = $request->input('amount');
        $success = $this->accountService->transfer($fromAccount, $toAccount, $amount);
        return response()->json(['success' => $success, 'from_balance' => $fromAccount->balance, 'to_balance' => $toAccount->balance]);
    }
}
