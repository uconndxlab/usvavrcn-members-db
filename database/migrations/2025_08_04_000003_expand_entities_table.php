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
        Schema::table('entities', function (Blueprint $table) {
            // Professional Information
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->text('biography')->nullable();
            
            // Professional Details  
            $table->string('company')->nullable();
            $table->string('affiliation')->nullable(); // More generic than coe_affiliation
            $table->text('funding_sources')->nullable();
            
            // Contact Information
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            
            // Additional Professional Fields
            $table->text('expertise')->nullable();
            $table->text('publications')->nullable();
            $table->text('awards')->nullable();
            
            // Profile Settings
            $table->boolean('is_public')->default(true);
            $table->boolean('allow_contact')->default(true);
            $table->json('social_links')->nullable(); // Store multiple social media links
            
            // Administrative
            $table->string('status')->default('active'); // active, inactive, pending
            $table->timestamp('profile_completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'biography', 'company', 'affiliation',
                'funding_sources', 'address', 'city', 'state', 'country', 'postal_code',
                'expertise', 'publications', 'awards', 'is_public', 'allow_contact',
                'social_links', 'status', 'profile_completed_at'
            ]);
        });
    }
};
