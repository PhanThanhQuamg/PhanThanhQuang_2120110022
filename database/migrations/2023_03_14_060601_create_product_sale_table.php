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
        Schema::create('ptq_product_sale', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->float('price_sale');
            $table->dateTime('date_begin');
            $table->dateTime('date_end');
            $table->unsignedTinyInteger('create_by');
            $table->unsignedTinyInteger('update_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptq_product_sale');
    }
};
