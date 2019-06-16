<?php

namespace Tests\Feature;

use App\Enums\PrizeTypes;
use App\Models\Number;
use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Tests\Traits\HasUserInteraction;
use Tests\Traits\MigrateFreshSeedOnce;

class WinningNumberGeneratorTest extends TestCase
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
                             'prize_type' => 'just a test',
                         ]);

        $response->assertStatus(422);
    }

    public function test_non_admin_cannot_see_draw_creation_page()
    {
        $user     = $this->createUser();
        $response = $this->actingAs($user)->get('/backend/draws/create');

        $response->assertStatus(403);
    }

    public function test_number_is_generated_from_users_with_most_count_of_numbers_if_its_first_price()
    {
        $user          = $this->createAdminUser();
        $highest_count = Number::highestCountByUsers();
        $user_ids      = User::withMoreThanNumberCount($highest_count - 1)->pluck('id');
        $response      = $this->actingAs($user)
                              ->json('get', '/backend/winning-number', [
                                  'prize_type' => (string)PrizeTypes::FIRST(),
                              ]);
        $number        = json_decode($response->content());

        $this->assertTrue($user_ids->contains($number->user_id));
    }

    public function test_number_is_generated_from_users_without_most_count_of_numbers_if_its_second_or_third_price()
    {
        $user          = $this->createAdminUser();
        $highest_count = Number::highestCountByUsers();
        $user_ids      = User::withLessThanNumberCount($highest_count)->pluck('id');
        $types         = [(string)PrizeTypes::SECOND(), (string)PrizeTypes::THIRD()];
        $response      = $this->actingAs($user)
                              ->json('get', '/backend/winning-number', [
                                  'prize_type' => Arr::random($types),
                              ]);
        $number        = json_decode($response->content());

        $this->assertTrue($user_ids->contains($number->user_id));
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
