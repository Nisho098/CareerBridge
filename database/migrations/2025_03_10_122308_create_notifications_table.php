<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');  // Changed user_id to student_id
            $table->string('message');
            $table->enum('type', ['accepted', 'rejected']);  // Enum for 'accepted' or 'rejected'
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
