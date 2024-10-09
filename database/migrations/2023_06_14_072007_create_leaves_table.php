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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();

            $table->integer('employee_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('leave_date')->nullable();
            $table->string('leave_date_from')->nullable();
            $table->string('leave_date_to')->nullable();
            $table->integer('leave_type')->nullable();
            $table->string('day_type')->nullable();
            $table->string('status')->nullable();
            $table->string('approver_id')->nullable();
            $table->text('reason')->nullable();
            $table->text('decline_reason')->nullable();

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
        Schema::dropIfExists('leaves');
    }
};
