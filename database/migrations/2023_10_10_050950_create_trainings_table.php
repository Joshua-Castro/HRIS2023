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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('cost')->nullable();
            $table->string('title')->nullable();
            $table->string('status')->nullable();
            $table->time('end_time')->nullable();
            $table->string('duration')->nullable();
            $table->time('start_time')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->date('end_date_time')->nullable();
            $table->date('start_date_time')->nullable();
            $table->string('trainer_instructor')->nullable();

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
        Schema::dropIfExists('trainings');
    }
};
