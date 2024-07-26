<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDip12SnilsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('phone', function ($table) {
                $table->string('diploma_1')->nullable();
                $table->string('diploma_2')->nullable();
                $table->string('snils')->nullable();
                $table->string('organization_name')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['diploma_1', 'diploma_2', 'snils', 'organization_name']);
        });
    }
};
