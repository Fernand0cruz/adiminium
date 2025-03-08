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
    Schema::create('companies', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->unique()->nullable()->constrained()->onDelete('cascade');
        $table->string('photo')->nullable(); 
        $table->string('cnpj', 14)->unique();
        $table->string('business_name');
        $table->string('phone', 11);
        $table->string('address');
        $table->string('street');
        $table->string('neighborhood');
        $table->string('state');
        $table->string('number');
        $table->string('city');
        $table->string('zip_code');
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
