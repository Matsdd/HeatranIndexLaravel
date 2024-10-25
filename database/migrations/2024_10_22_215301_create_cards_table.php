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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rarity');
            $table->string('era');
            $table->string('type');
            $table->string('language');
            $table->string('stamped');
            $table->string('cardMarketLink');
            $table->string('image_path');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Card uploader
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
