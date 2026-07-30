<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('applications')) {
            return;
        }

        DB::table('applications')
            ->where('status', 'new')
            ->update(['status' => 'applied']);

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE applications MODIFY status ENUM('applied', 'shortlisted', 'interview', 'rejected', 'hired') NOT NULL DEFAULT 'applied'");

            return;
        }

        if ($driver === 'sqlite') {
            Schema::table('applications', function (Blueprint $table) {
                $table->string('status_tmp', 32)->default('applied');
            });

            DB::table('applications')->update([
                'status_tmp' => DB::raw('status'),
            ]);

            Schema::table('applications', function (Blueprint $table) {
                $table->dropColumn('status');
            });

            Schema::table('applications', function (Blueprint $table) {
                $table->renameColumn('status_tmp', 'status');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('applications')) {
            return;
        }

        DB::table('applications')
            ->where('status', 'hired')
            ->update(['status' => 'shortlisted']);

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE applications MODIFY status ENUM('applied', 'shortlisted', 'interview', 'rejected') NOT NULL DEFAULT 'applied'");
        }
    }
};
