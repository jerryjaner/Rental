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
        Schema::create('renew_apartment_contracts', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('rent_info_id');
            $table->date('renew_start_date')->nullable();
            $table->date('renew_end_date')->nullable();
            $table->timestamps();

            $table->foreign('rent_info_id')
                  ->references('id')
                  ->on('rent_information')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renew_apartment_contracts');
    }
};
