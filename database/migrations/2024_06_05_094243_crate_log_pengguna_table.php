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

        Schema::create('log_pengguna', function (Blueprint $table) {
            $table->id('id');
            $table->string('ip_address', 100);
            $table->string('browser', 100);
            $table->string('platform', 100);
            $table->string('device', 100);
            $table->string('negara', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
