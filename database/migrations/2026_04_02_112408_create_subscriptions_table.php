<?php

use App\Domain\User\Models\User;
use App\Domain\Plan\Models\Plan;
use App\Domain\Subscription\Enums\PaymentMethodEnum;
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
        Schema::create('subscriptions', function (Blueprint $table): void {
            $table->id();

            $table->uuid('uuid')
                ->unique()
                ->index();

            /* 
            |-------------------------------
            | Subscription Info
            |-------------------------------
            */
            $table->decimal('amount', 10, 2)
                ->index();

            $table->enum('payment_method', PaymentMethodEnum::values());

            $table->unsignedInteger('total_sessions');

            $table->unsignedInteger('used_sessions')
                ->default(0);

            /* 
            |-------------------------------
            | Forgien Keys
            |-------------------------------
            */
            $table->foreignIdFor(Plan::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            /* 
            |-------------------------------
            | Spatie State
            |-------------------------------
            */
            $table->string('subscription_state');

            /* 
            |-------------------------------
            | Status Flags
            |-------------------------------
            */
            $table->boolean('is_active')
                ->default(false);

            $table->boolean('is_current')
                ->default(true);

            /* 
            |-------------------------------
            | Dates
            |-------------------------------
            */
            $table->timestamp('next_renewal_at')
                ->nullable();

            $table->timestamp('expire_at')
                ->nullable();

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
        Schema::dropIfExists('subscriptions');
    }
};
