<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('delivery_person_id')->constrained('staff')->onDelete('cascade');
            $table->enum('status', [
                         'assigned',
                         'picked_up',
                         'on_the_way',
                         'delivered',
                         'cancelled'
                         ])->default('assigned');

           $table->string('location')->nullable();
           $table->time('estimated_time')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('deliveries');
    }
};
