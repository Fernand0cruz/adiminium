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
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('photo')->nullable(); 
        $table->string('cnpj', 14)->unique();
        $table->string('business_name');
        $table->string('phone');
        $table->string('street');
        $table->string('neighborhood');
        $table->string('state', 2);
        $table->string('number', 10);
        $table->string('city');
        $table->string('postal_code', 10);
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
