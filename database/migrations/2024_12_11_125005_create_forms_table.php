<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female']);
            $table->enum('course', [
                '.net developer',
                'php developer',
                'python developer',
                'vue js developer',
                'java developer',
                'react developer',
                'UX/UI designer'
            ]);
            $table->integer('course_number')->nullable();
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->enum('role', ['mentor', 'student']);
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('forms');
    }
};
