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
        Schema::create('order_circulars', function (Blueprint $table) {
            $table->id();
            $table->string('type',2);
            $table->string('go_type',3)->nullable();
            $table->string('number');
            $table->date('date');
            $table->string('title');
            $table->string('keywords')->nullable();
            $table->string('path');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_circulars');
    }
};
