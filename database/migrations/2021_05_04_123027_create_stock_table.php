<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->string('book_name');
            $table->string('book_author');
            $table->date('book_publication_date');
            $table->string('book_isbn_no')->primary()->unique();
            $table->text('book_description');
            $table->double('book_trade_price');
            $table->double('book_retail_price');
            $table->integer('book_quantity');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE stock ADD book_front_cover LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock');
    }
}
