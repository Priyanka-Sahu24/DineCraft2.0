<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
    Schema::create('staff', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('employee_id')->unique();
        $table->enum('designation', ['chef','waiter','cashier','manager','delivery']);
        $table->decimal('salary', 10, 2);
        $table->date('joining_date');
        $table->enum('shift', ['morning','evening']);
        $table->enum('status', ['active','terminated'])->default('active');
        $table->timestamps();
    });
}

public function down() {
    Schema::dropIfExists('staff');
}

};
