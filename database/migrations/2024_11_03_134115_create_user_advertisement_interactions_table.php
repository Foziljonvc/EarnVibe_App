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
        Schema::create('user_advertisement_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('advertisement_id')->constrained('advertisements')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('has_liked')->default(false);
            $table->boolean('has_saved')->default(false);
            $table->boolean('has_shared')->default(false);
            $table->bigInteger('coins_earned')->default(0);
            $table->bigInteger('watched_duration')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_advertisement_interactions');
    }
};
