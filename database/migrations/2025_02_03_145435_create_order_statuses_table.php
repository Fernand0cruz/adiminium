<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        
        DB::table('order_statuses')->insert([
            ['name' => 'open'],
            ['name' => 'in progress'],
            ['name' => 'accepted'],
            ['name' => 'denied'],
            ['name' => 'cancelled'],
        ]);
        
    }

    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
