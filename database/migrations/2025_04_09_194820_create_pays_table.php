<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->decimal('amount', 8, 2);
            $table->date('payment_date');
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pays');
    }
};