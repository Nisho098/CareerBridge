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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('recruiter_id'); // Foreign key to RecruiterProfiles table
            $table->string('title', 100);
            $table->text('description');
            $table->string('location', 100)->nullable();
            $table->enum('job_type', ['full-time', 'part-time', 'internship']);
            $table->string('industry')->nullable();
            $table->text('requirements')->nullable();
            $table->timestamp('posted_at')->useCurrent();
            $table->timestamp('application_deadline')->nullable();
            $table->decimal('salary', 10, 2)->nullable(); // Salary amount
            $table->enum('salary_type', ['hourly', 'monthly', 'project-based'])->default('monthly'); 
            $table->json('benefits')->nullable(); 
            $table->string('project_duration')->nullable(); 
            $table->string('payment_terms')->nullable(); 
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->timestamps(); 

            // Foreign key constraint
            $table->foreign('recruiter_id')->references('id')->on('recruiter_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
