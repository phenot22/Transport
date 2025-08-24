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
        // Create the 'messages' table
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            // Create the 'usertype' column
            $table->unsignedBigInteger('usertype');
            
            // Create the 'message' column for the message content
            $table->text('message');
            
            // Add timestamps to track the creation and update times
            $table->timestamps();
    
            // Add the foreign key constraint for 'usertype' referencing the 'id' column in the 'users' table
            $table->foreign('usertype')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'messages' table if it exists
        Schema::dropIfExists('messages');
    }
};
