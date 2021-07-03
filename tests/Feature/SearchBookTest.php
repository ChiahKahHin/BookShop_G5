<?php

namespace Tests\Feature;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Http\Request;

class SearchBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_search_by_name()
    {
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );

        $response = $this->followingRedirects()->actingAs($user)->post(route("homeSearch", ["homeSearch" => "To Kill a Mockingbird"]));
        $response->assertViewHas("stock", function($stock) {
            $check = true;
            $check = $stock[0]->book_name == "To Kill a Mockingbird" && $check;
            $check = $stock[0]->book_author == "Harper Lee" && $check;
            $check = $stock[0]->book_publication_date == "1988-10-11" && $check;
            $check = $stock[0]->book_isbn_no == "978-0-44-631078-9" && $check;
            $check = $stock[0]->book_description == "The unforgettable novel of a childhood in a sleepy Southern town and the crisis of conscience that rocked it, To Kill A Mockingbird became both an instant bestseller and a critical success when it was first published in 1960. It went on to win the Pulitzer Prize in 1961 and was later made into an Academy Award-winning film, also a classic. Compassionate, dramatic, and deeply moving, To Kill A Mockingbird takes readers to the roots of human behavior - to innocence and experience, kindness and cruelty, love and hatred, humor and pathos. Now with over 18 million copies in print and translated into forty languages, this regional story by a young Alabama woman claims universal appeal. Harper Lee always considered her book to be a simple love story. Today it is regarded as a masterpiece of American literature." && $check;
            $check = $stock[0]->book_trade_price == 56 && $check;
            $check = $stock[0]->book_retail_price == 66.5 && $check;
            $check = $stock[0]->book_quantity == 20 && $check;

            return $check;
        });
    }

    public function test_search_by_author()
    {
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );

        $response = $this->followingRedirects()->actingAs($user)->post(route("homeSearch", ["homeSearch" => "Harper Lee"]));
        $response->assertViewHas("stock", function($stock) {
            $check = true;
            $check = $stock[0]->book_name == "To Kill a Mockingbird" && $check;
            $check = $stock[0]->book_author == "Harper Lee" && $check;
            $check = $stock[0]->book_publication_date == "1988-10-11" && $check;
            $check = $stock[0]->book_isbn_no == "978-0-44-631078-9" && $check;
            $check = $stock[0]->book_description == "The unforgettable novel of a childhood in a sleepy Southern town and the crisis of conscience that rocked it, To Kill A Mockingbird became both an instant bestseller and a critical success when it was first published in 1960. It went on to win the Pulitzer Prize in 1961 and was later made into an Academy Award-winning film, also a classic. Compassionate, dramatic, and deeply moving, To Kill A Mockingbird takes readers to the roots of human behavior - to innocence and experience, kindness and cruelty, love and hatred, humor and pathos. Now with over 18 million copies in print and translated into forty languages, this regional story by a young Alabama woman claims universal appeal. Harper Lee always considered her book to be a simple love story. Today it is regarded as a masterpiece of American literature." && $check;
            $check = $stock[0]->book_trade_price == 56 && $check;
            $check = $stock[0]->book_retail_price == 66.5 && $check;
            $check = $stock[0]->book_quantity == 20 && $check;

            return $check;
        });
    }

    public function test_search_by_isbn()
    {
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );

        $response = $this->followingRedirects()->actingAs($user)->post(route("homeSearch", ["homeSearch" => "978-0-44-631078-9"]));
        $response->assertViewHas("stock", function($stock) {
            $check = true;
            $check = $stock[0]->book_name == "To Kill a Mockingbird" && $check;
            $check = $stock[0]->book_author == "Harper Lee" && $check;
            $check = $stock[0]->book_publication_date == "1988-10-11" && $check;
            $check = $stock[0]->book_isbn_no == "978-0-44-631078-9" && $check;
            $check = $stock[0]->book_description == "The unforgettable novel of a childhood in a sleepy Southern town and the crisis of conscience that rocked it, To Kill A Mockingbird became both an instant bestseller and a critical success when it was first published in 1960. It went on to win the Pulitzer Prize in 1961 and was later made into an Academy Award-winning film, also a classic. Compassionate, dramatic, and deeply moving, To Kill A Mockingbird takes readers to the roots of human behavior - to innocence and experience, kindness and cruelty, love and hatred, humor and pathos. Now with over 18 million copies in print and translated into forty languages, this regional story by a young Alabama woman claims universal appeal. Harper Lee always considered her book to be a simple love story. Today it is regarded as a masterpiece of American literature." && $check;
            $check = $stock[0]->book_trade_price == 56 && $check;
            $check = $stock[0]->book_retail_price == 66.5 && $check;
            $check = $stock[0]->book_quantity == 20 && $check;

            return $check;
        });
    }

    public function test_search_not_found()
    {
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );

        $response = $this->followingRedirects()->actingAs($user)->post(route("homeSearch", ["homeSearch" => "anything"]));
        $response->assertViewIs("noresult");
    }
}
