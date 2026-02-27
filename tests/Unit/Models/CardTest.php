<?php

namespace Tests\Unit\Models;

use App\Models\Card;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardTest extends TestCase
{
    use RefreshDatabase;

    public function test_card_can_be_created(): void
    {
        $profile = Profile::factory()->create();

        $card = Card::create([
            'profile_id' => $profile->id,
            'name' => 'Nubank',
            'type' => 'credit',
            'last_four_digits' => '1234',
            'limit' => 10000.00,
            'color' => '#820AD1',
        ]);

        $this->assertDatabaseHas('cards', [
            'name' => 'Nubank',
            'type' => 'credit',
            'last_four_digits' => '1234',
        ]);
    }

    public function test_card_belongs_to_profile(): void
    {
        $profile = Profile::factory()->create();

        $card = Card::create([
            'profile_id' => $profile->id,
            'name' => 'Nubank',
            'type' => 'credit',
            'last_four_digits' => '1234',
            'limit' => 10000.00,
        ]);

        $this->assertInstanceOf(Profile::class, $card->profile);
    }

    public function test_card_has_valid_types(): void
    {
        $profile = Profile::factory()->create();

        $credit = Card::create([
            'profile_id' => $profile->id,
            'name' => 'Cartão Crédito',
            'type' => 'credit',
            'last_four_digits' => '1234',
            'limit' => 5000.00,
        ]);

        $debit = Card::create([
            'profile_id' => $profile->id,
            'name' => 'Cartão Débito',
            'type' => 'debit',
            'last_four_digits' => '5678',
            'limit' => 0,
        ]);

        $this->assertEquals('credit', $credit->type);
        $this->assertEquals('debit', $debit->type);
    }
}
