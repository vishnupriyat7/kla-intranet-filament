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
            $table->string('sub_type')->nullable()->after('type');
            $table->string('sub_sub_type')->nullable()->after('sub_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_circulars', function (Blueprint $table) {
            $table->dropColumn('sub_type');
            $table->dropColumn('sub_sub_type');
        });
    }
};
