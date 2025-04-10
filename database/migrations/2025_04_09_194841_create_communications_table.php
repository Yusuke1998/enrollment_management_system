<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->date('sent_date');
            $table->nullableMorphs('communicable'); // Para asociar con padres o cursos.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};