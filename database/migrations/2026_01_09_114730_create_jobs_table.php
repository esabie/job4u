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
    Schema::create('jobs', function (Blueprint $table) {
        $table->id();

        $table->string('title');
        $table->string('company_name');
        $table->string('location');
        $table->string('employment_type'); // Full Time, Part Time, Contract
        $table->string('category');        // Tech, Healthcare, etc

        $table->integer('salary_min')->nullable();
        $table->integer('salary_max')->nullable();

        $table->boolean('is_verified')->default(false);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
