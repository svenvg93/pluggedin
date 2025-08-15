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
        Schema::create('device_model', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('device_type')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->string('vendor')->nullable();
            $table->string('color', 7)->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_model');
    }
};
