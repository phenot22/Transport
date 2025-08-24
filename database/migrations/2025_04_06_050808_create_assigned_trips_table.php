<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assigned_trips', function (Blueprint $table) {
            $table->id();
            $table->string('status');                
            $table->unsignedBigInteger('trip_id')->nullable(); // Ensure it's nullable for ON DELETE SET NULL
            $table->string('type');
            $table->decimal('distance', 8, 2);
            $table->decimal('cost', 10, 2);
            $table->string('name');
            $table->string('address');
            $table->string('contact');
            $table->string('schedule');
            $table->string('compname'); // company name
            $table->string('owner_name');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('trip_id')
                  ->references('id')
                  ->on('trips')
                  ->onDelete('SET NULL');  // If trip is deleted, trip_id becomes NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_trips');
    }
};
