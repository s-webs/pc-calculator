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
        Schema::create('pc_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('pc_category_id')->constrained();
            $table->text('image')->nullable();
            $table->string('name');
            $table->integer('prime_cost')->nullable();
            $table->integer('sale_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('available')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pc_components');
    }
};
