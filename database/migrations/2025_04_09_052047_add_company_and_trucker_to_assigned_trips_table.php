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
        Schema::table('assigned_trips', function (Blueprint $table) {
            $table->string('trucker_name')->nullable()->after('owner_name');
        });
    }

    public function down(): void
    {
        Schema::table('assigned_trips', function (Blueprint $table) {
            $table->dropColumn(['trucker_name']);
        });
    }
};
