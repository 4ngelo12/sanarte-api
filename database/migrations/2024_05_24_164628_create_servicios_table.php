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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 45)->unique();
            $table->text('description');
            $table->text('warning')->nullable();
            $table->string('image', length: 60);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 60);
            $table->text('description')->nullable();
            $table->string('image', length: 60);
            $table->decimal('price', total: 8, places: 2)->nullable();
            $table->integer('duration')->nullable();
            $table->boolean('state')->default(value: true);
            $table->foreignId('category_id')->constrained(table: 'categories', indexName: 'category_id');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('services');
    }
};
