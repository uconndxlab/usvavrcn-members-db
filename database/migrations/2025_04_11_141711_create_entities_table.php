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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->enum('entity_type', ['person', 'group']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('coe_affiliation')->nullable();
            $table->string('lab_group')->nullable();
            $table->text('research_interests')->nullable();
            $table->text('projects')->nullable();
            $table->timestamp('creation_date')->nullable();
            $table->timestamp('last_updated')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('job_title')->nullable();
            $table->string('primary_institution_name')->nullable();
            $table->string('primary_institution_department')->nullable();
            $table->string('primary_institution_mailing')->nullable();
            $table->string('secondary_institution_name')->nullable();
            $table->string('website')->nullable();
            $table->string('career_stage')->nullable();
            $table->string('photo_src')->nullable();
            $table->timestamps(); // for created_at and updated_at
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
