<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_keyword', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('keyword_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Índice único para evitar duplicados en la relación
            $table->unique(['task_id', 'keyword_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_keyword');
    }
};