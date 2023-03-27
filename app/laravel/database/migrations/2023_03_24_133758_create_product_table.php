<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('itemId')->nullable();
            $table->double('price')->nullable();
            $table->string('imageUrl')->nullable();
            $table->string('productName')->nullable();
            $table->string('offerLink')->nullable();
            $table->string('productLink')->nullable();
            $table->string('shopName')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('products');
    }
};
