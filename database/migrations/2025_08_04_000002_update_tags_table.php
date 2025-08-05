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
        Schema::table('tags', function (Blueprint $table) {
            $table->foreignId('tag_category_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('slug')->nullable();
            $table->string('color')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable(); // For storing additional tag-specific data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['tag_category_id']);
            $table->dropColumn([
                'tag_category_id', 
                'slug', 
                'color', 
                'sort_order', 
                'is_active', 
                'metadata'
            ]);
        });
    }
};
