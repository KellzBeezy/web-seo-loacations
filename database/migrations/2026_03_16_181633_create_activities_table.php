<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->index()->default('default');
            $table->string('description');
            $table->string('level')->default('info');

            // User relationship (Standard)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Tenant relationship (Explicitly naming 'app_tenants')
            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained('app_tenants') // <--- Specify the table name here
                ->onDelete('cascade');

            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
