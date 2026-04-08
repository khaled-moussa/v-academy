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
        Schema::create('social_accounts', function (Blueprint $table): void {
            $table->id();

            $table->uuid('uuid')
                ->unique()
                ->index();

            /* 
            |-------------------------------
            | Social Account Info
            |-------------------------------
             */
            $table->string('social_id');

            $table->string('provider');

            /* 
            |-------------------------------
            | Relationships
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
        Schema::dropIfExists('social_accounts');
    }
};
