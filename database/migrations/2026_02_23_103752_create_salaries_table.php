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
     Schema::create('salaries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
    $table->decimal('basic_salary', 10, 2);
    $table->decimal('bonus', 10, 2)->default(0);
    $table->decimal('deduction', 10, 2)->default(0);
    $table->decimal('net_salary', 10, 2);
    $table->string('month');
    $table->string('year');
    $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
    $table->date('paid_date')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
