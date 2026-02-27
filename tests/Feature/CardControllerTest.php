<?php

namespace Tests\Feature;

use App\Models\Card;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_cards(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        Card::factory()->count(3)->create(['profile_id' => $profile->id]);

        $response = $this->actingAs($user)->get('/cards');

        $response->assertStatus(200);
    }

    public function test_can_create_card(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/cards', [
            'profile_id' => $profile->id,
            'name' => 'Nubank',
            'type' => 'credit',
            'last_four_digits' => '1234',
            'limit' => 10000.00,
            'color' => '#820AD1',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('cards', ['name' => 'Nubank']);
    }

    public function test_can_update_card(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $card = Card::factory()->create(['profile_id' => $profile->id]);

        $response = $this->actingAs($user)->put("/cards/{$card->id}", [
            'name' => 'Nubank Updated',
            'type' => 'debit',
            'limit' => 5000.00,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('cards', ['name' => 'Nubank Updated']);
    }

    public function test_can_delete_card(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $card = Card::factory()->create(['profile_id' => $profile->id]);

        $response = $this->actingAs($user)->delete("/cards/{$card->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('cards', ['id' => $card->id]);
    }
}
