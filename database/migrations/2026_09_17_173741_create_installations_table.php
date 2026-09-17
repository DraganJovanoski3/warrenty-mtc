<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installations', function (Blueprint $table) {
            $table->id();

            // Customer / Company
            $table->string('company_name');
            $table->string('tax_id')->nullable();
            $table->text('customer_address');
            $table->string('installer_company_name');

            // Truck
            $table->string('truck_number');
            $table->string('vin');
            $table->unsignedInteger('mileage_at_installation')->nullable();
            $table->date('installation_date');

            // Part & Purchase (linked to product catalog)
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->string('part_number');
            $table->string('part_description');
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installations');
    }
};
