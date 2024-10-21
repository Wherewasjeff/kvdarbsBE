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
        Schema::create('workinghours', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->boolean('weekend');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workinghours');
    }
};
