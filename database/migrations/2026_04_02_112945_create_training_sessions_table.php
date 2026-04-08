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
        Schema::create('training_sessions', function (Blueprint $table): void {
            $table->id();

            $table->uuid('uuid')
                ->unique()
                ->index();

            /* 
            |-------------------------------
            | Training Session Info
            |-------------------------------
            */
            $table->string('name')
                ->nullable()
                ->index();

            $table->integer('capacity')
                ->default(1)
                ->index();

            $table->integer('booking')
                ->default(0);

            $table->string('session_state');

            $table->date('session_date');

            $table->time('session_time');

            /* 
            |-------------------------------
            | Forgien Keys
            |-------------------------------
            */
            $table->foreignId('user_created_session_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /* 
            |-------------------------------
            | Conditions
            |-------------------------------
            */
            $table->boolean('is_admin_created')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

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
        Schema::dropIfExists('training_sessions');
    }
};