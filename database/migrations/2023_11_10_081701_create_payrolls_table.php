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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->decimal('basic_salary', 10, 2)->nullable();
            $table->decimal('overtime_hours', 5, 2)->nullable();
            $table->decimal('bonuses', 10, 2)->nullable();
            $table->decimal('total_deductions', 10, 2)->nullable();
            $table->decimal('sss', 10, 2)->nullable();
            $table->decimal('pagibig', 10, 2)->nullable();
            $table->decimal('philhealth', 10, 2)->nullable();
            $table->decimal('absences', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('allowances', 10, 2)->nullable();
            $table->decimal('net_salary', 10, 2)->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
