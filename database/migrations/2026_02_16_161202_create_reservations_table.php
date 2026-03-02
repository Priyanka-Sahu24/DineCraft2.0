<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->integer('guest_count');
            $table->enum('status', ['pending','confirmed','cancelled','completed'])->default('pending');
            $table->text('special_request')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('reservations');
    }
};
