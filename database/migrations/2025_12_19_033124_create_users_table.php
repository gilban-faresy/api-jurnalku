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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('nis')->unique();

            $table->unsignedBigInteger('rombel_id');
            $table->unsignedBigInteger('rayon_id');

            $table->string('email')->nullable();
            $table->string('password');

            $table->timestamps();

            $table->foreign('rombel_id')
                ->references('id_rombel')
                ->on('rombels')
                ->cascadeOnDelete();

            $table->foreign('rayon_id')
                ->references('id_rayon')
                ->on('rayons')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
