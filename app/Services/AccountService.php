<?php

namespace App\Services;

use App\Models\Account;

class AccountService
{
    public function createAccount(): Account
    {
        return Account::create(['balance' => 0]);
    }

    public function deposit(Account $account, float $amount): bool
    {
        if ($amount <= 0 || $amount > 6000 || $this->isInvalidDecimal($amount)) {
            return false;
        }
        $account->balance += $amount;
        return $account->save();
    }

    public function withdraw(Account $account, float $amount): bool
    {
        if ($amount <= 0 || $amount > 6000 || $amount > $account->balance || $this->isInvalidDecimal($amount)) {
            return false;
        }
        $account->balance -= $amount;
        return $account->save();
    }

    public function transfer(Account $fromAccount, Account $toAccount, float $amount): bool
    {
        if ($amount <= 0 || $amount > 3000 || $this->isInvalidDecimal($amount) || $fromAccount->balance < $amount) {
            return false;
        }

        $fromAccount->balance -= $amount;
        $toAccount->balance += $amount;

        return $fromAccount->save() && $toAccount->save();
    }

    private function isInvalidDecimal(float $amount): bool
    {
        return round($amount, 2) != $amount;
    }
}
