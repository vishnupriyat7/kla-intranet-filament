<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_circulars', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_type')->nullable()->change();
            $table->unsignedBigInteger('sub_sub_type')->nullable()->change();
            $table->foreign('sub_type')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_sub_type')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_circulars', function (Blueprint $table) {
            //
        });
    }
};
