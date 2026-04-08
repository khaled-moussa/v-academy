<?php

use App\Domain\TrainingSession\Models\TrainingSession;
use App\Domain\User\Models\User;
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
        Schema::create('training_session_joins', function (Blueprint $table): void {
            $table->id();

            $table->uuid('uuid')
                ->unique()
                ->index();

            /* 
            |-------------------------------
            | States
            |-------------------------------
            */
            $table->boolean('attendance')
                ->default(false);

            /* 
            |-------------------------------
            | Forgien Keys
            |-------------------------------
            */
            $table->foreignIdFor(TrainingSession::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            /* 
            |-------------------------------
            | Timestamps
            |-------------------------------
            */
            $table->timestamps();

            /* 
            |-------------------------------
            | Constraints (IMPORTANT)
            |-------------------------------
            */
            $table->unique(
                ['training_session_id', 'user_id'],
                'unique_user_session_join'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_session_joins');
    }
};
