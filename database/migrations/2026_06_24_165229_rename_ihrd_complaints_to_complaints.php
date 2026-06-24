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
        Schema::rename('ihrd_complaints', 'complaints');
        
        Schema::table('helpdesk_tickets', function (Blueprint $table) {
            $table->renameColumn('ihrd_complaint_id', 'vendor_complaint_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpdesk_tickets', function (Blueprint $table) {
            $table->renameColumn('vendor_complaint_id', 'ihrd_complaint_id');
        });
        
        Schema::rename('complaints', 'ihrd_complaints');
    }
};
