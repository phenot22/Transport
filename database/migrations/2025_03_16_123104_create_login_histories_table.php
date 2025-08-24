<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('login_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('email')->nullable();
            $table->string('ip_address');
            $table->string('user_agent');
            $table->timestamp('login_time')->useCurrent();
            $table->timestamp('logout_time')->nullable(); // Add logout_time column
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('login_histories');
    }
};
