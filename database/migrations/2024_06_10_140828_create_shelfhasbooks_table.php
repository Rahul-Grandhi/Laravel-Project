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
        Schema::create('shelfhasbooks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shelf_id');
            $table->unsignedBigInteger('book_id');
            $table->timestamps();


            $table->foreign('shelf_id')->references('id')->on('shelf');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelfhasbooks');
    }
};
