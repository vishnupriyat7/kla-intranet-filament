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
        Schema::table('periodicals', function (Blueprint $table) {
            //add status column to periodicals table after path boolean value 0/1
            $table->string('status',1)->default('0')->after('path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periodicals', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
