<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('business_name');
            $table->string('cnpj', 14)->unique();
            $table->string('phone', 11);
            $table->string('email');
            $table->string('web_site');
            $table->string('address');
            $table->string('state');
            $table->string('city');
            $table->string('zip_code');
            $table->string('neighborhood');
            $table->string('street');
            $table->string('number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
