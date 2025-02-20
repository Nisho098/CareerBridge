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
        Schema::create('recruiter_profiles', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('user_id')->unique(); // Foreign key to Users table, unique constraint
            $table->string('name');
            $table->string('company_website', 255)->nullable();
            $table->string('contact_number', 15)->nullable();
            $table->text('details', 255)->nullable();
            $table->text('personaldetails', 255)->nullable();
            $table->string('address')->nullable(); 
            $table->text('aboutcompany', 255)->nullable();
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
        Schema::dropIfExists('recruiter_profiles');
    }
};
