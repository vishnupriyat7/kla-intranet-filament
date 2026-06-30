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
        Schema::table('vendor_complaints', function (Blueprint $table) {
            $table->renameColumn('complaint_id', 'vendor_complaint_no');
            $table->renameColumn('description', 'complaint_description');
            $table->renameColumn('report_description', 'chm_remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_complaints', function (Blueprint $table) {
            $table->renameColumn('vendor_complaint_no', 'complaint_id');
            $table->renameColumn('complaint_description', 'description');
            $table->renameColumn('chm_remark', 'report_description');
        });
    }
};
