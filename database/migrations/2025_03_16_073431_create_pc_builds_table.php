<?php

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
        Schema::create('pc_builds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('image')->nullable();
            $table->string('name');
            $table->json('components')->nullable();
            $table->integer('prime_cost')->default(0);
            $table->integer('sale_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('available')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pc_builds');
    }
};
