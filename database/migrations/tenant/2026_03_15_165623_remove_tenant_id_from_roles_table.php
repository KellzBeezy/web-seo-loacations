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
        Schema::table('roles', function (Blueprint $table) {
            // 1. Drop the unique constraint
            // Laravel naming convention for this index is usually: table_column1_column2_unique
            $table->dropUnique(['tenant_id', 'slug']);

            // 2. Now drop the column
            $table->dropColumn('tenant_id');

            // 3. Optional: Add a standard unique index to slug if it's now global
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->after('id');
            $table->unique(['tenant_id', 'slug']);
            $table->dropUnique(['slug']);
        });
    }
};
