<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Order matters: categories and entities must exist before tags and
     * relationships that reference them.
     */
    public function run(): void
    {
        $this->call([
            EntitySeeder::class,        // people + groups (entities table)
            TagCategorySeeder::class,   // tag categories
            TagSeeder::class,           // tags (references tag_categories)
            EntityTagSeeder::class,     // entity ↔ tag pivot (references both)
            EntityGroupSeeder::class,   // entity ↔ group pivot (references entities)
        ]);
    }
}
