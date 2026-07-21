<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/tags.csv');

        if (!File::exists($path)) {
            $this->command->error("CSV not found at: $path");
            return;
        }

        $csv = array_map('str_getcsv', file($path));
        $headers = array_map('trim', array_shift($csv));

        foreach ($csv as $index => $row) {
            $row = array_pad($row, count($headers), null);
            $data = array_combine($headers, $row);
            $data = array_map(fn($v) => (is_string($v) && trim($v) === '') ? null : (is_string($v) ? trim($v) : $v), $data);

            try {
                Tag::updateOrCreate(
                    ['id' => $data['id']],
                    [
                        'name'            => $data['name'],
                        'slug'            => $data['slug'],
                        'description'     => $data['description'],
                        'tag_category_id' => $data['tag_category_id'],
                        'parent_tag_id'   => $data['parent_tag_id'],
                        'color'           => $data['color'],
                        'sort_order'      => (int) ($data['sort_order'] ?? 0),
                        'is_active'       => (bool) ($data['is_active'] ?? true),
                        'metadata'        => $data['metadata'],
                    ]
                );
            } catch (\Exception $e) {
                $this->command->error("Error on row $index: " . $e->getMessage());
            }
        }

        $this->command->info("Tags seeded successfully.");
    }
}
