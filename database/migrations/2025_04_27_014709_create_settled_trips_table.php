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
        Schema::create('settled_trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->string('type');
            $table->float('distance');
            $table->decimal('cost', 8, 2);
            $table->string('name');
            $table->string('address');
            $table->string('contact');
            $table->string('schedule');
            $table->string('compname');
            $table->string('owner_name');
            $table->string('trucker_name');                                    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settled_trips');
    }
};
