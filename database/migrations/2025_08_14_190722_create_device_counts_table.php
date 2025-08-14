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
        Schema::create('device_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->constrained('device_models')->cascadeOnDelete();
            $table->date('recorded_at');
            $table->unsignedInteger('count')->default(0);
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->unique(['model_id', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_counts');
    }
};
