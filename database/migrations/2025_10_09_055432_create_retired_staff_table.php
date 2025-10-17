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
        Schema::create('retired_staffs', function (Blueprint $table) {
            $table->id();
            $table->string('name_eng');
            $table->string('name_mal')->nullable();
            $table->string('gender')->nullable();
            $table->string('retired_as')->nullable();
            $table->date('retired_on')->nullable();
            $table->text('address')->nullable();
            $table->string('district')->nullable();
            $table->string('pin')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('kla_id')->nullable();
            $table->string('mail_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retired_staffs');
    }
};
