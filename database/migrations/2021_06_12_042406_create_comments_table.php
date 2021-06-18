<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->index();
            $table->string("isbn")->index();
            $table->integer("rating");
            $table->text("content")->nullable();
            $table->text("mimeType")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE comments ADD attachment LONGBLOB NULL DEFAULT NULL AFTER `mimeType`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
