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
        Schema::create('doctor_info', function (Blueprint $table) {
            $table->id();
            $table->string('bef_name');
            $table->string('bmdc_registration_no');
            $table->integer('phone_no')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('degree');
            $table->string('specialist');
            $table->string('sub_specialist');
            $table->string('Experience');
            $table->enum('active_status', ['active', 'inactive', 'pending', 'cancel', 'banned']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_info');
    }
};
