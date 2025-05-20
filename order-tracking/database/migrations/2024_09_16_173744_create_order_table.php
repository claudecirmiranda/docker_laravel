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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('channel');
            $table->string('origin_zipcode');
            $table->string('origin_title');
            $table->string('estimated_delivery');
            $table->string('destination_zipcode');
            $table->string('destination_city');
            $table->string('destination_state');
            $table->longtext('raw');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
