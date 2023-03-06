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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_accesstrade');
            /*
                DEFAULT,
                ACCESSTRADE,
                SHOPEE
            */
            $table->string('type')->default('DEFAULT');
            $table->text('api_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_accesstrade')->default(false);
            $table->dropColumn('type');
        });
    }
};
