<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            $table->foreignId('organization_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();

            $table->string('company')->nullable();
            $table->string('job_title')->nullable();

            $table->string('status')->default('active');

            $table->timestamps();

            $table->index('organization_id');
            $table->index('email');
            $table->index('phone');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};