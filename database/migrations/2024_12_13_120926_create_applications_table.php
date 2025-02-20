<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('student_id'); // Foreign key to StudentProfiles table
            $table->unsignedBigInteger('job_id'); // Foreign key to Jobs table
            $table->text('cover_letter')->nullable();
            $table->enum('application_status', ['submitted', 'under review', 'rejected', 'accepted'])->default('submitted');
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamps(); 

            // Foreign key constraints
            $table->foreign('student_id')->references('id')->on('student_profiles')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
