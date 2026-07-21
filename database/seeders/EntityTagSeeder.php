<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EntityTagSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/entity_tag.csv');

        if (!File::exists($path)) {
            $this->command->error("CSV not found at: $path");
            return;
        }

        $csv = array_map('str_getcsv', file($path));
        $headers = array_map('trim', array_shift($csv));

        $rows = [];
        $now = now()->toDateTimeString();

        foreach ($csv as $row) {
            $row = array_pad($row, count($headers), null);
            $data = array_combine($headers, $row);

            $rows[] = [
                'entity_id'  => (int) $data['entity_id'],
                'tag_id'     => (int) $data['tag_id'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert in chunks to avoid hitting SQLite variable limits
        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('entity_tag')->insertOrIgnore($chunk);
        }

        $this->command->info("Entity-tag relationships seeded (" . count($rows) . " rows).");
    }
}
