<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
        });
        Schema::table('staff', function (Blueprint $table) {
            $table->enum('status', ['active','on leave','terminated'])->default('active')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['emergency_contact_name','emergency_contact_phone']);
        });
        Schema::table('staff', function (Blueprint $table) {
            $table->enum('status', ['active','terminated'])->default('active')->change();
        });
    }
};
