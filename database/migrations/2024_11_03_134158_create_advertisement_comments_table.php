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
        Schema::create('advertisement_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('advertisement_comments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('advertisement_id')->constrained('advertisements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->text('content');
            $table->bigInteger('likes_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisement_comments');
    }
};
