<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('type');
            $table->float('distance');
            $table->float('cost');
            $table->string('name');
            $table->string('address');
            $table->string('contact');
            $table->date('schedule');
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};