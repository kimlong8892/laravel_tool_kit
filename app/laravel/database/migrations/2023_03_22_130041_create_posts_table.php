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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('image');
            $table->text('description');
            $table->longText('content');
            $table->string('status');
            $table->double('view')->default(0);
            $table->text('slug')->unique();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('posts');
    }
};
