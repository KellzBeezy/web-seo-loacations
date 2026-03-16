<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ChangeFrequency;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('suburb');
            $table->enum('change_frequency', array_column(ChangeFrequency::cases(), 'value'))
                ->default(ChangeFrequency::WEEKLY->value);
            $table->timestamps();

            // This creates the composite unique constraint
            $table->unique(['city', 'suburb']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
