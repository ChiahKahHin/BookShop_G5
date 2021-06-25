<?php

namespace Tests\Feature;

use App\Http\Controllers\StateController;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class GetDeliveryCostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $states = array(
        "Perlis",
        "Kedah",
        "Kelantan",
        "Perak",
        "Pahang",
        "Johor",
        "Terengganu",
        "Selangor",
        "Negeri Sembilan",
        "Malacca",
        "Sabah",
        "Sarawak"
    );

    public function setUp(): void {
        parent::setUp();
        $this->statesWithDeliveryCost = [
            "Kedah" => 3,
            "Perak" => 1,
            "Pahang" => 3,
            "Sabah" => 8,
            "Malacca" => 8,
            "Johor" => 4
        ];
        foreach ($this->statesWithDeliveryCost as $state => $cost) {
            State::factory()->create([
                "state" => $state,
                "delivery_cost" => $cost
            ]);
        }
    }

    public function tearDown(): void {
        parent::tearDown();
        unset($this->statesWithDeliveryCost);
    }

    public function test_get_delivery_cost()
    {
        $statesWithCosts = $this->statesWithDeliveryCost;
        foreach ($this->states as $state) {
            $request = new Request(["q" => Str::lower($state)]);
            $controller = new StateController();
            $cost = $controller->getState($request);
            if (array_key_exists($state, $statesWithCosts)) {
                $this->assertEquals($cost, $statesWithCosts[$state]);
            }
            else {
                $this->assertEquals($cost, 5);
            }
        }
    }
}
