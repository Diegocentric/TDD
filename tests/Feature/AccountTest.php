<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_creation()
    {
        $response = $this->post('/accounts');
        $response->assertStatus(200)
            ->assertJson(['balance' => 0]);
    }

    public function test_deposit()
    {
        $account = Account::create();

        $response = $this->post("/accounts/{$account->id}/deposit", ['amount' => 100]);
        $response->assertStatus(200)
            ->assertJson(['success' => true, 'balance' => 100]);

        $response = $this->post("/accounts/{$account->id}/deposit", ['amount' => -100]);
        $response->assertStatus(200)
            ->assertJson(['success' => false, 'balance' => 100]);
    }

    public function test_withdraw()
    {
        $account = Account::create(['balance' => 500]);

        $response = $this->post("/accounts/{$account->id}/withdraw", ['amount' => 100]);
        $response->assertStatus(200)
            ->assertJson(['success' => true, 'balance' => 400]);

        $response = $this->post("/accounts/{$account->id}/withdraw", ['amount' => 600]);
        $response->assertStatus(200)
            ->assertJson(['success' => false, 'balance' => 400]);
    }

    public function test_transfer()
    {
        $fromAccount = Account::create(['balance' => 500]);
        $toAccount = Account::create(['balance' => 50]);

        $response = $this->post("/accounts/{$fromAccount->id}/transfer/{$toAccount->id}", ['amount' => 100]);
        $response->assertStatus(200)
            ->assertJson(['success' => true, 'from_balance' => 400, 'to_balance' => 150]);

        $response = $this->post("/accounts/{$fromAccount->id}/transfer/{$toAccount->id}", ['amount' => 6000]);
        $response->assertStatus(200)
            ->assertJson(['success' => false, 'from_balance' => 400, 'to_balance' => 150]);
    }
}
