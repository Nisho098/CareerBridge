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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('user_id')->unique(); // Foreign key to Users table, unique constraint
            $table->string('name', 100);
            $table->string('university_name', 255)->nullable();
            $table->text('about', 255)->nullable();
            
            $table->integer('graduation_year')->nullable();
            $table->string('skills')->nullable(); 
            $table->string('contact')->nullable(); // Add contact field
            $table->string('location')->nullable(); 
            $table->string('resume_url', 255)->nullable();
            $table->string('portfolio_url', 255)->nullable();
            $table->string('profile_picture')->nullable(); // Profile picture column

            $table->timestamps(); 

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_profiles');
    }
};
