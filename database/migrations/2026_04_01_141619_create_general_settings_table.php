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
        Schema::create('general_settings', function (Blueprint $table): void {
            $table->id();

            $table->uuid('uuid')
                ->unique()
                ->index();

            /* 
            |-------------------------------
            | General Settings
            |-------------------------------
            */
            $table->string('site_name')
                ->default(config('app.name'));

            $table->mediumText('slugon');

            $table->longText('description');

            $table->json('phones')
                ->nullable();

            $table->string('address')
                ->default(config('company-info.address'));

            $table->longText('location_url')
                ->nullable();

            $table->string('support_email')
                ->default(config('company-info.support_email'));

            $table->integer('max_capacity')
                ->default(8);

            $table->boolean('user_can_create_session')
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
        Schema::dropIfExists('general_settings');
    }
};
