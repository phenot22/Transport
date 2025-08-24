<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('archived_trips', function (Blueprint $table) {
            $table->id();
            $table->string('status');            
            $table->string('type');
            $table->decimal('distance', 8, 2);
            $table->decimal('cost', 10, 2);
            $table->string('name');
            $table->string('address');
            $table->string('contact');
            $table->dateTime('schedule');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('archived_trips');
    }
};
