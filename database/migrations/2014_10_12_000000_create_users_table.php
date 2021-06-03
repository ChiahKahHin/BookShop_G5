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
            $table->double('wallet_balance')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            "email" => "customer1@gmail.com",
            "username" => "customer1",
            "phone" => "012-3456789",
            "role" => 1,
            "password" => Hash::make("12345678"),
            "wallet_balance" => 10
        ]);

        User::create([
            "email" => "customer2@gmail.com",
            "username" => "customer2",
            "phone" => "012-3456789",
            "role" => 1,
            "password" => Hash::make("12345678")
        ]);

        User::create([
            "email" => "admin@gmail.com",
            "username" => "admin",
            "phone" => "012-3456789",
            "role" => 0,
            "password" => Hash::make("p455w0rd")
        ]);

        User::create([
            "email" => "admin1@gmail.com",
            "username" => "admin1",
            "phone" => "012-3456789",
            "role" => 0,
            "password" => Hash::make("12345678")
        ]);

        User::create([
            "email" => "admin2@gmail.com",
            "username" => "admin2",
            "phone" => "012-3456789",
            "role" => 0,
            "password" => Hash::make("12345678")
        ]);
        
        User::create([
            "email" => "admin3@gmail.com",
            "username" => "admin3",
            "phone" => "012-3456789",
            "role" => 0,
            "password" => Hash::make("12345678")
        ]);

        User::create([
            "email" => "admin4@gmail.com",
            "username" => "admin4",
            "phone" => "012-3456789",
            "role" => 0,
            "password" => Hash::make("12345678")
        ]);

        User::create([
            "email" => "admin5@gmail.com",
            "username" => "admin5",
            "phone" => "012-3456789",
            "role" => 0,
            "password" => Hash::make("12345678")
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
