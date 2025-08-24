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
        Schema::create('selected_trips', function (Blueprint $table) {
            $table->id();
            $table->string('status');                
            $table->unsignedBigInteger('trip_id')->nullable(); // Allow trip_id to be nullable
            $table->string('type');
            $table->decimal('distance', 8, 2);
            $table->decimal('cost', 10, 2);
            $table->string('name');
            $table->string('address');
            $table->string('contact');
            $table->string('schedule');
            $table->timestamps();
    
            // Add the foreign key constraint with onDelete('SET NULL')
            $table->foreign('trip_id')
                  ->references('id')
                  ->on('trips')
                  ->onDelete('SET NULL');  // Set trip_id to NULL if the trip is deleted
        });
    }
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_trips');
    }
};
