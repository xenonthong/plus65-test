<?php

namespace Tests\Feature;

use App\Enums\PrizeTypes;
use App\Models\Draw;
use App\Models\Number;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Tests\Traits\HasUserInteraction;
use Tests\Traits\MigrateFreshSeedOnce;

class DrawTest extends TestCase
{
    use HasUserInteraction, MigrateFreshSeedOnce;

    protected function deleteAllDrawResults()
    {
        Draw::query()->delete();
    }

    public function test_admin_can_save_draw_results()
    {
        $this->deleteAllDrawResults();

        $user     = $this->createAdminUser();
        $type     = Arr::random(PrizeTypes::toArray());
        $response = $this->actingAs($user)->json('get', '/backend/winning-number', [
            'prize_type' => $type,
        ]);
        $number   = json_decode($response->content());

        $this->actingAs($user)->json('post', '/backend/draws', [
            'type'   => $type,
            'number' => $number->value,
        ]);

        $this->assertDatabaseHas('draws', ['number' => $number->value]);
    }

    public function test_cannot_save_draw_result_if_number_already_exists_in_draws_table()
    {
        $this->deleteAllDrawResults();

        $number = Number::first(); // use a valid number if not validation will fail it we use a fake number.
        $draw   = Draw::forceCreate([
            'number'  => $number->value,
            'type'    => PrizeTypes::THIRD(),
            'user_id' => $number->user_id,
        ]);

        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->json('post', '/backend/draws', [
            'type'   => $draw->type,
            'number' => $number->value,
        ]);

        $this->assertStringContainsString('The number has already been taken.', $response->getContent());
    }

    public function test_cannot_save_draw_result_if_number_does_not_exist_in_numbers_table()
    {
        $this->deleteAllDrawResults();

        $user     = $this->createAdminUser();
        $response = $this->actingAs($user)->json('post', '/backend/draws', [
            'type'   => PrizeTypes::FIRST(),
            'number' => 1234567,
        ]);

        $this->assertStringContainsString('The selected number is invalid.', $response->content());
    }

    public function test_cannot_save_draw_result_if_prize_type_limit_has_reached()
    {
        $this->deleteAllDrawResults();

        $user = $this->createAdminUser();

        Draw::forceCreate([
            'number'  => 12345,
            'user_id' => 9999,
            'type'    => PrizeTypes::FIRST(),
        ]);

        $response = $this->actingAs($user)->json('post', '/backend/draws', [
            'type'   => PrizeTypes::FIRST(),
            'number' => Number::first()->value, // use a valid number if not validation will fail it we use a fake number.
        ]);

        $this->assertStringContainsString("Limit for this prize type has been reached.", $response->content());
    }

    public function test_cannot_save_draw_result_if_user_has_already_won_a_draw()
    {
        $this->deleteAllDrawResults();

        $user   = $this->createAdminUser();
        $number = Number::first();

        Draw::forceCreate([
            'number'  => 12345,
            'user_id' => $number->user_id,
            'type'    => PrizeTypes::FIRST(),
        ]);

        $response = $this->actingAs($user)->json('post', '/backend/draws', [
            'type'   => PrizeTypes::FIRST(),
            'number' => $number->value,
        ]);

        $this->assertStringContainsString("This number belongs to an existing winner.", $response->content());
    }

    public function test_non_admin_cannot_save_draw_results()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->json('post', '/backend/draws', [
            'type'   => PrizeTypes::FIRST(),
            'number' => Number::first()->value, // use a valid number if not validation will fail it we use a fake number.
        ]);

        $response->assertStatus(403);
    }
}
