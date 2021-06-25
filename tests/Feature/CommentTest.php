<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Comment;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void {
        parent::setUp();
        $this->book = Stock::factory()->create(
            [
                "book_name" => $this->faker->sentence(5),
                'book_author' => $this->faker->name,
                'book_publication_date' => $this->faker->date(),
                'book_isbn_no' => $this->faker->unique()->regexify("/^(?=(?:\d+-){4})\d{3}-[-\d]{13}$/"),
                'book_description' => $this->faker->sentence(80),
                'book_trade_price' => $this->faker->randomFloat(2, 0, 500),
                'book_retail_price' => $this->faker->randomFloat(2, 0, 500),
                'book_quantity' => $this->faker->numberBetween(0, 20),
                'book_front_cover' => file_get_contents("public\\assets\\img\\book\\tokillamockingbird.jpg")
            ]
        );
        $this->customerWithComment = User::factory()->has(Comment::factory()->count(1)->state([
            "isbn" => $this->book->book_isbn_no,
            "rating" => $this->faker->numberBetween(1, 5),
            "content" => $this->faker->sentence(25)
        ]), "comments")
        ->create(
            [
                'username' => $this->faker->name,
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );

        $this->customerWithoutComment = User::factory()->create(
            [
                'username' => $this->faker->name,
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );
    }

    public function tearDown(): void {
        parent::tearDown();
        unset($this->book);
        unset($this->customerWithComment);
        unset($this->customerWithoutComment);
    }

    public function test_post_comment()
    {
        $book = $this->book;
        $customer = $this->customerWithoutComment;

        $rate = 1;
        $content = $this->faker->sentence(50);

        $response = $this->actingAs($customer)
        ->post(route("addcomment", ["isbn" => $book->book_isbn_no]), [
            "rate" => $rate,
            "content" => $content
        ]);

        $response->assertSessionHas(["message" => "Your comment has been added successfully"]);
        $this->assertDatabaseHas("comments", [
            "rating" => $rate,
            "content" => $content
        ]);
    }

    public function test_edit_comment()
    {
        $book = $this->book;
        $customer = $this->customerWithComment;
        $comment = $customer->comments[0];

        $newRate = $this->faker->numberBetween(1, 5);
        $newContent = $this->faker->sentence(50);
        //before editing the comment
        $this->assertDatabaseHas("comments", [
            "user_id" => $customer->id,
            "rating" => $comment->rating,
            "content" => $comment->content
        ]);

        $response = $this->actingAs($customer)
        ->post(route("editcomment", ["isbn" => $book->book_isbn_no]), [
            "rate" => $newRate,
            "content" => $newContent
        ]);
        //after edit the comment
        $response->assertSessionHas(["message" => "Your comment has been updated successfully"]);
        $this->assertDatabaseHas("comments", [
            "user_id" => $customer->id,
            "rating" => $newRate,
            "content" => $newContent
        ]);
        $this->assertDatabaseMissing("comments", [
            "rating" => $comment->rating,
            "content" => $comment->content
        ]);
    }
}
