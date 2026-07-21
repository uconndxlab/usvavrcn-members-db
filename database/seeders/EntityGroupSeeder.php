<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EntityGroupSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/entity_group.csv');

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
                'group_id'   => (int) $data['group_id'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('entity_group')->insertOrIgnore($chunk);
        }

        $this->command->info("Entity-group memberships seeded (" . count($rows) . " rows).");
    }
}
