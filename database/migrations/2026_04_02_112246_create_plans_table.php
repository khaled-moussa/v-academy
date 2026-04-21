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
        Schema::create('plans', function (Blueprint $table): void {
            $table->id();

            $table->uuid('uuid')
                ->unique()
                ->index();

            /* 
            |-------------------------------
            | Plan Info
            |-------------------------------
            */
            $table->string('name')
                ->index();

            $table->decimal('price', 10, 2);

            $table->integer('discount')
                ->default(0);

            $table->unsignedBigInteger('no_of_sessions');

            $table->json('includes')
                ->nullable();

            /* 
            |-------------------------------
            | Conditions
            |-------------------------------
            */

            $table->boolean('is_popular')
                ->default(false);

            $table->boolean('is_active')
                ->default(false);

            /* 
            |-------------------------------
            | Timestamps
            |-------------------------------
            */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
