<?php

namespace Tests\Feature;

use App\Enums\PrizeTypes;
use Tests\TestCase;
use Tests\Traits\HasUserInteraction;
use Tests\Traits\MigrateFreshSeedOnce;

class DrawTest extends TestCase
{
    use HasUserInteraction, MigrateFreshSeedOnce;

    public function test_admin_can_generate_winning_number_with_valid_prize_type()
    {
        $user  = $this->createAdminUser();
        $types = PrizeTypes::toArray();
        $key   = array_rand($types);

        $response = $this->actingAs($user)
                         ->json('get', '/backend/winning-number', [
                             'prize_type' => $types[$key],
                         ]);

        $this->assertStringContainsString('value', $response->content());
    }

    public function test_admin_can_see_draw_creation_page()
    {
        $user     = $this->createAdminUser();
        $response = $this->actingAs($user)->get('/backend/draws/create');

        $response->assertStatus(200);
    }

    public function test_admin_cannot_generate_winning_number_with_invalid_prize_type()
    {
        $user     = $this->createAdminUser();
        $response = $this->actingAs($user)
                         ->json('get', '/backend/winning-number', [
                             'prize_type' => 'dsadsad',
                         ]);

        $response->assertStatus(422);
    }

    public function test_non_admin_cannot_see_draw_creation_page()
    {
        $user     = $this->createUser();
        $response = $this->actingAs($user)->get('/backend/draws/create');

        $response->assertStatus(403);
    }

    public function test_user_cannot_generate_winning_number_with_valid_prize_type()
    {
        $user  = $this->createUser();
        $types = PrizeTypes::toArray();
        $key   = array_rand($types);

        $response = $this->actingAs($user)
                         ->json('get', '/backend/winning-number', [
                             'prize_type' => $types[$key],
                         ]);

        $response->assertStatus(403);
    }
}
