<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
<<<<<<< HEAD:database/migrations/2014_10_12_000000_create_users_table.php
            $table->string('password')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('access_token')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->string('fcmtoken')->nullable();
            $table->integer('online')->default(1);
            $table->string('open_id')->nullable();
            $table->string('token')->nullable();
            $table->integer('type')->nullable();
            $table->foreignId('role_id')->constrained('roles')->nullable();
=======
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->foreignId('role_id')->constrained('roles');
>>>>>>> a4e47f92127689d3dc149a7b33a3523d336fb9ee:database/migrations/2023_09_24_182750_create_users_table.php
            $table->boolean('state')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
