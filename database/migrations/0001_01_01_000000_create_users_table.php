<?php

use App\Support\Enums\UserPanelEnum;
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
        Schema::create('users', function (Blueprint $table): void {
            $table->id();

            $table->uuid('uuid')
                ->unique()
                ->index();

            /* 
            |-------------------------------
            | Personal Info
            |------------------------------- 
            */
            $table->string('first_name')
                ->index();

            $table->string('last_name')
                ->index();

            $table->string('age')
                ->nullable();

            $table->string('gender');

            $table->string('sport')
                ->nullable();

            $table->integer('weight')
                ->nullable();

            $table->integer('height')
                ->nullable();

            /* 
            |-------------------------------
            | Medical Info
            |------------------------------- 
            */
            $table->longText('current_injury')
                ->nullable();

            $table->longText('previous_injury')
                ->nullable();

            /* 
            |-------------------------------
            | Contact Info
            |------------------------------- 
            */
            $table->string('phone')
                ->nullable()
                ->unique()
                ->index();

            $table->string('email')
                ->unique()
                ->index();

            $table->string('address')
                ->nullable();

            /* 
            |-------------------------------
            | System Info
            |------------------------------- 
            */
            $table->longText('notes')
                ->nullable();

            $table->enum('panel', UserPanelEnum::cases())
                ->default(UserPanelEnum::USER);

            $table->boolean('is_active')
                ->default(true);

            $table->string('password')
                ->nullable();

            /* 
            |-------------------------------
            | Social & Auth
            |------------------------------- 
            */
            $table->boolean('has_socialite')
                ->default(false);

            $table->rememberToken();

            /* 
            |-------------------------------
            | Timestamps
            |------------------------------- 
            */
            $table->timestamp('email_verified_at')
                ->nullable();

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // Body columns
            $table->string('email')
                ->primary();

            // Tokens
            $table->string('token');

            // Timestamps
            $table->timestamp('created_at')
                ->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')
                ->primary();

            // Body columns
            $table->string('ip_address', 45)
                ->nullable();

            $table->text('user_agent')
                ->nullable();

            $table->longText('payload');

            $table->integer('last_activity')
                ->index();

            // Foreign keys
            $table->foreignId('user_id')
                ->nullable()
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
