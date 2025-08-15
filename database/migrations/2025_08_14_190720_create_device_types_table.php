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
        Schema::create('device_type', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();          // gateway, access point, etc.
            $table->string('color', 7)->nullable();    // #RRGGBB for charts
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_type');
    }
};
