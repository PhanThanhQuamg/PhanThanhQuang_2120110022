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
        Schema::create('ptq_product_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('product_id');
            $table->string('image',1000);
            $table->unsignedInteger('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptq_product_image');
    }
};
