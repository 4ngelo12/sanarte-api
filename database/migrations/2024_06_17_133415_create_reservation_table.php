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
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 25)->unique();

            $table->timestamps();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date_reservation');
            $table->time('time_reservation');
            $table->foreignId('status_id')->constrained(table: 'status', indexName: 'status_id')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained(table: 'services', indexName: 'service_id')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained(table: 'clients', indexName: 'client_id')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained(table: 'users', indexName: 'user_id')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status');
        Schema::dropIfExists('reservation');
    }
};
