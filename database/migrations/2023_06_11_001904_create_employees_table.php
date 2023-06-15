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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            
            $table->integer('user_id')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('maiden_name')->nullable();
            $table->string('position')->nullable();
            $table->string('last_promotion')->nullable();
            $table->string('station_code')->nullable();
            $table->string('control_no')->nullable();
            $table->string('employee_no')->nullable();
            $table->string('school_code')->nullable();
            $table->string('item_number')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('salary_grade')->nullable();
            $table->string('date_hired')->nullable();
            $table->string('sss')->nullable();
            $table->string('pag_ibig')->nullable();
            $table->string('phil_health')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
