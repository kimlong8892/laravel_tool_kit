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
        Schema::create('accesstrade_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('cookie_duration');
            $table->string('logo');
            $table->string('max_com');
            $table->string('merchant');
            $table->string('name');
            $table->string('scope');
            $table->string('accesstrade_id')->unique();
            $table->string('name_custom')->nullable();
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
        Schema::dropIfExists('accesstrade_campaigns');
    }
};
