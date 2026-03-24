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
        Schema::create('helpdesk_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->unique();

            $table->string('employee_id'); // PEN or ID
            $table->string('section');

            $table->foreignId('office_location_id')->nullable();
            $table->string('floor')->nullable();
            $table->foreignId('room_id')->nullable();

            $table->string('complaint_type');
            $table->text('description');

            $table->enum('status', ['Open', 'Assigned', 'In Progress', 'Resolved', 'Closed'])
                ->default('Open');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpdesk_tickets');
    }
};