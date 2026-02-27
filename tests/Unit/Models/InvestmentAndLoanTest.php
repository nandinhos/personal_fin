<?php

namespace Tests\Unit\Models;

use App\Models\Investment;
use App\Models\Loan;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvestmentAndLoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_investment_can_be_created(): void
    {
        $profile = Profile::factory()->create();

        $investment = Investment::create([
            'profile_id' => $profile->id,
            'name' => 'Tesouro Direto',
            'type' => 'fixed_income',
            'amount' => 10000.00,
            'current_value' => 10500.00,
        ]);

        $this->assertDatabaseHas('investments', ['name' => 'Tesouro Direto']);
    }

    public function test_loan_can_be_created(): void
    {
        $profile = Profile::factory()->create();

        $loan = Loan::create([
            'profile_id' => $profile->id,
            'name' => 'Empréstimo Pessoal',
            'amount' => 5000.00,
            'remaining_amount' => 4500.00,
            'interest_rate' => 2.5,
        ]);

        $this->assertDatabaseHas('loans', ['name' => 'Empréstimo Pessoal']);
    }
}
