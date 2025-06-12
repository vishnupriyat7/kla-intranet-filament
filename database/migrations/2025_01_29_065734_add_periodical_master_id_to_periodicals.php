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
            $table->dropColumn('name_eng');
            $table->unsignedBigInteger('periodical_master_id')->after('id');
            $table->foreign('periodical_master_id')->references('id')->on('periodical_masters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periodicals', function (Blueprint $table) {
            $table->string('name_eng');
            $table->dropForeign(['periodical_master_id']);
            $table->dropColumn('periodical_master_id');
        });
    }
};
