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
        Schema::create('rent_information', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('room_number')->nullable();
            $table->string('tenant_name')->nullable();
            $table->decimal('rent_fee', 10, 2);
            $table->string('status')->nullable();
            $table->softdeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_information');
    }
};
