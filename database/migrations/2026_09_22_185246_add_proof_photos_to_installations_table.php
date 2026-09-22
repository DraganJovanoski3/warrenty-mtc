<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->string('vin_photo')->nullable()->after('vin');
            $table->string('mileage_photo')->nullable()->after('mileage_at_installation');
        });
    }

    public function down(): void
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->dropColumn(['vin_photo', 'mileage_photo']);
        });
    }
};
