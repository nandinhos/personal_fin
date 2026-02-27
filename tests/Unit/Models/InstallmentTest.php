<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Installment;
use App\Models\Profile;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstallmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_installment_can_be_created(): void
    {
        $profile = Profile::factory()->create();
        $category = Category::factory()->create(['profile_id' => $profile->id]);
        $transaction = Transaction::factory()->create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
        ]);

        $installment = Installment::create([
            'transaction_id' => $transaction->id,
            'profile_id' => $profile->id,
            'installment_number' => 1,
            'total_installments' => 12,
            'amount' => 150.00,
            'due_date' => now()->addMonth(),
            'is_paid' => false,
        ]);

        $this->assertDatabaseHas('installments', [
            'installment_number' => 1,
            'total_installments' => 12,
            'amount' => 150.00,
        ]);
    }

    public function test_installment_belongs_to_transaction(): void
    {
        $profile = Profile::factory()->create();
        $category = Category::factory()->create(['profile_id' => $profile->id]);
        $transaction = Transaction::factory()->create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
        ]);

        $installment = Installment::create([
            'transaction_id' => $transaction->id,
            'profile_id' => $profile->id,
            'installment_number' => 1,
            'total_installments' => 6,
            'amount' => 200.00,
            'due_date' => now()->addMonth(),
        ]);

        $this->assertInstanceOf(Transaction::class, $installment->transaction);
    }

    public function test_installment_can_be_marked_as_paid(): void
    {
        $profile = Profile::factory()->create();
        $category = Category::factory()->create(['profile_id' => $profile->id]);
        $transaction = Transaction::factory()->create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
        ]);

        $installment = Installment::create([
            'transaction_id' => $transaction->id,
            'profile_id' => $profile->id,
            'installment_number' => 1,
            'total_installments' => 3,
            'amount' => 100.00,
            'due_date' => now(),
            'is_paid' => false,
        ]);

        $installment->update(['is_paid' => true]);

        $this->assertTrue($installment->fresh()->is_paid);
    }
}
