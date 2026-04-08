<?php

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
        Schema::create('nutration_plans', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')
                ->unique()
                ->index();

            /* 
            |-------------------------------
            | Training Session Info
            |-------------------------------
            */
            $table->string('meal')
                ->index();

            $table->longText('saturday');

            $table->longText('sunday');

            $table->longText('monday');

            $table->longText('tuesday');

            $table->longText('wednesday');

            $table->longText('thursday');

            $table->longText('friday');

            /* 
            |-------------------------------
            | Forgien Keys
            |-------------------------------
            */

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

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
        Schema::dropIfExists('nutration_plans');
    }
};
