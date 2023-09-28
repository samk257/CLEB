<?php

use App\Models\TypeTutoring;
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
        Schema::create('order_tutors', function (Blueprint $table) {
            $table->id();
            $table->foreignId(User::class)->constrained();
            $table->foreignId(TypeTutoring::class)->constrained();
            $table->string('courses');
            $table->string('class');
            $table->string('school_attend');
            $table->string('days');
            $table->string('hours');
            $table->string('phone_number');
            $table->string('address');
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tutors');
    }
};
