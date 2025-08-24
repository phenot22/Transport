<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('selected_trips', function (Blueprint $table) {
            $table->string('compname')->nullable()->after('schedule');
            $table->string('owner_name')->nullable()->after('compname');
        });
    }
    
    public function down(): void
    {
        Schema::table('selected_trips', function (Blueprint $table) {
            $table->dropColumn(['compname', 'owner_name']);
        });
    }
};
