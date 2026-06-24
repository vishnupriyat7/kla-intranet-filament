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
        Schema::create('ihrd_complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_id');
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->string('report_no')->nullable();
            $table->text('report_description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ihrd_complaints');
    }
};
