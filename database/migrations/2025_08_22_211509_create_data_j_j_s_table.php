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
        Schema::create('data_jj', function (Blueprint $table) {
            $table->id();
            $table->string('username1');
            $table->string('username2')->nullable();
            $table->string('id_member')->nullable();
            $table->foreignId('viewer_id')->constrained('data_viewers')->onDelete('cascade');
            $table->string('filename');
            $table->integer('duration');
            $table->integer('size');
            $table->boolean('sts_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_jj');
    }
};
