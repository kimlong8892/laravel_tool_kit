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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('accesstrade_cookie_duration')->nullable();
            $table->string('accesstrade_logo')->nullable();
            $table->string('accesstrade_max_com')->nullable();
            $table->string('accesstrade_merchant')->nullable();
            $table->string('accesstrade_name')->nullable();
            $table->string('accesstrade_scope')->nullable();
            $table->string('accesstrade_id')->unique()->nullable();
            $table->string('name')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('campaigns');
    }
};
