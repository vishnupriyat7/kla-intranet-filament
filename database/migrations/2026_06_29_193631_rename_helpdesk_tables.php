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
        Schema::rename('helpdesk_tickets', 'complaint_tickets');
        Schema::rename('helpdesk_status_histories', 'complaint_status_histories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('complaint_status_histories', 'helpdesk_status_histories');
        Schema::rename('complaint_tickets', 'helpdesk_tickets');
    }
};
