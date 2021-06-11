<?php

namespace Tests\Feature;

use App\Http\Controllers\StockController;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;

class CheckISBNTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $isbn_no = "123-1-12-123456-1";
    
    public function setUp(): void {
        parent::setUp();
        $this->stock = Stock::factory()->create(
            [
                'book_name' => 'To Kill a Mockingbird',
                'book_author' => 'Harper Lee',
                'book_publication_date' => '1988-10-11',
                'book_isbn_no' => $this->isbn_no,
                'book_description' => 'The unforgettable novel of a childhood in a sleepy Southern town and the crisis of conscience that rocked it, To Kill A Mockingbird became both an instant bestseller and a critical success when it was first published in 1960. It went on to win the Pulitzer Prize in 1961 and was later made into an Academy Award-winning film, also a classic. Compassionate, dramatic, and deeply moving, To Kill A Mockingbird takes readers to the roots of human behavior - to innocence and experience, kindness and cruelty, love and hatred, humor and pathos. Now with over 18 million copies in print and translated into forty languages, this regional story by a young Alabama woman claims universal appeal. Harper Lee always considered her book to be a simple love story. Today it is regarded as a masterpiece of American literature.',
                'book_trade_price' => '56',
                'book_retail_price' => '66.50',
                'book_quantity' => '20',
                'created_at' => '2021-05-19 20:14:05',
                'updated_at' => '2021-05-19 20:14:05',
                'book_front_cover' => file_get_contents("public\\assets\\img\\book\\tokillamockingbird.jpg")
            ]
        );
    }

    public function tearDown(): void {
        parent::tearDown();
        unset($this->stock);
    }

    public function test_isbn_unique() {
        $request = new Request(['isbn' => '123-1-12-123456-2']);
        $controller = new StockController();
        $this->assertFalse($controller->checkISBN($request));
    }

    public function test_isbn_duplicate() {
        $stock = $this->stock;
        
        $request = new Request(['isbn' => $this->isbn_no]);
        $controller = new StockController();
        $this->assertTrue($controller->checkISBN($request));
    }
}
