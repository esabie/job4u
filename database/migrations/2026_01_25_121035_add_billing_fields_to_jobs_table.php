<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            if (!Schema::hasColumn('jobs', 'is_paid')) {
                $table->boolean('is_paid')->default(false)->after('is_verified');
            }

            if (!Schema::hasColumn('jobs', 'stripe_session_id')) {
                $table->string('stripe_session_id')->nullable()->after('is_paid');
            }

            if (!Schema::hasColumn('jobs', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_paid');
            }
        });
    }

    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            if (Schema::hasColumn('jobs', 'is_paid')) {
                $table->dropColumn('is_paid');
            }

            if (Schema::hasColumn('jobs', 'stripe_session_id')) {
                $table->dropColumn('stripe_session_id');
            }

            if (Schema::hasColumn('jobs', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
