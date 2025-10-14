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
        Schema::table('order_circulars', function (Blueprint $table) {
             $table->integer('title_length')->nullable()->after('status');
            $table->string('error_type')->nullable()->after('title_length');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_circulars', function (Blueprint $table) {
           $table->dropColumn(['title_length', 'error_type']);
        });
    }
};
