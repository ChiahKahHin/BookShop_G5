<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role'); //admin-0, customer-1
            $table->string('address')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            "email" => "admin@gmail.com",
            "username" => "admin",
            "phone" => "012-3456789",
            "role" => 0,
            "password" => Hash::make("p455w0rd")
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
