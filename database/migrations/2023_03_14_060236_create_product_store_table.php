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
        Schema::create('ptq_product_store', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('product_id');
            $table->float('price');
            $table->unsignedTinyInteger('qty');
            $table->unsignedTinyInteger('create_by');
            $table->unsignedTinyInteger('update_by');
            $table->timestamps();
        });
    }
//unsignedTinyInteger
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptq_product_store');
    }
};
