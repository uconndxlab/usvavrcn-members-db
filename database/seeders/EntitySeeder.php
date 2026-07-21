<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entity;
use Illuminate\Support\Facades\File;

class EntitySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/entities.csv');

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
                Entity::updateOrCreate(
                    ['id' => $data['id']],
                    [
                        'entity_type'                   => $data['entity_type'],
                        'name'                          => $data['name'],
                        'first_name'                    => $data['first_name'],
                        'last_name'                     => $data['last_name'],
                        'email'                         => $data['email'],
                        'phone'                         => $data['phone'],
                        'job_title'                     => $data['job_title'],
                        'career_stage'                  => $data['career_stage'],
                        'coe_affiliation'               => $data['coe_affiliation'],
                        'affiliation'                   => $data['affiliation'],
                        'primary_institution_name'      => $data['primary_institution_name'],
                        'primary_institution_department'=> $data['primary_institution_department'],
                        'primary_institution_mailing'   => $data['primary_institution_mailing'],
                        'secondary_institution_name'    => $data['secondary_institution_name'],
                        'company'                       => $data['company'],
                        'lab_group'                     => $data['lab_group'],
                        'description'                   => $data['description'],
                        'biography'                     => $data['biography'],
                        'research_interests'            => $data['research_interests'],
                        'expertise'                     => $data['expertise'],
                        'projects'                      => $data['projects'],
                        'publications'                  => $data['publications'],
                        'awards'                        => $data['awards'],
                        'funding_sources'               => $data['funding_sources'],
                        'address'                       => $data['address'],
                        'city'                          => $data['city'],
                        'state'                         => $data['state'],
                        'country'                       => $data['country'],
                        'postal_code'                   => $data['postal_code'],
                        'website'                       => $data['website'],
                        'linkedin'                      => $data['linkedin'],
                        'photo_src'                     => $data['photo_src'],
                        'social_links'                  => $data['social_links'],
                        'is_public'                     => (bool) ($data['is_public'] ?? true),
                        'allow_contact'                 => (bool) ($data['allow_contact'] ?? true),
                        'status'                        => $data['status'] ?? 'active',
                        'creation_date'                 => $data['creation_date'],
                        'last_updated'                  => $data['last_updated'],
                    ]
                );
            } catch (\Exception $e) {
                $this->command->error("Error on row $index: " . $e->getMessage());
            }
        }

        $this->command->info("Entities seeded successfully.");
    }
}
