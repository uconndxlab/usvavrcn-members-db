<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entity;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class EntitySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/entity.csv');

        if (!File::exists($path)) {
            $this->command->error("CSV not found at: $path");
            return;
        }

        $csv = array_map('str_getcsv', file($path));
        $headers = array_map('trim', array_shift($csv)); // Get headers

        foreach ($csv as $index => $row) {

            // Pad row to match header length (use null for missing values)
            $row = array_pad($row, count($headers), null);

            // Combine the header with the row, ensuring keys are correct
            $data = array_combine($headers, $row);

            // Handle the missing fields
            $data = array_map(function ($value) {
                return is_string($value) ? trim($value) : $value;
            }, $data);

            try {
                // Update or create the entity
                Entity::updateOrCreate(
                    ['id' => $data['EntityId']],
                    [
                        'entity_type' => $data['EntityType'] ?? null,
                        'name' => $data['Name'] ?? null,
                        'description' => $data['Description'] ?? null,
                        'email' => $data['Email'] ?? null,
                        'phone' => $data['Phone'] ?? null,
                        'coe_affiliation' => $data['COEAffiliation'] ?? null,
                        'lab_group' => $data['LabGroup'] ?? null,
                        'research_interests' => $data['ResearchInterests'] ?? null,
                        'projects' => $data['Projects'] ?? null,
                        'creation_date' => isset($data['CreationDate']) ? Carbon::parse($data['CreationDate'])->format('Y-m-d H:i:s') : null,
                        'last_updated' => isset($data['LastUpdated']) ? Carbon::parse($data['LastUpdated'])->format('Y-m-d H:i:s') : null,
                        'linkedin' => $data['LinkedIn'] ?? null,
                        'job_title' => $data['JobTitle'] ?? null,
                        'primary_institution_name' => $data['PrimaryInstitutionName'] ?? null,
                        'primary_institution_department' => $data['PrimaryInstitutionDepartment'] ?? null,
                        'primary_institution_mailing' => $data['PrimaryInstitutionMailing'] ?? null,
                        'secondary_institution_name' => $data['SecondaryInstitutionName'] ?? null,
                        'website' => $data['website'] ?? null,
                        'career_stage' => $data['careerStage'] ?? null,
                        'photo_src' => $data['photoSrc'] ?? null,
                    ]
                );
            } catch (\Exception $e) {
                // Log or display the error
                $this->command->error("Error on row $index: " . $e->getMessage());
            }
        }

        $this->command->info("Entities imported successfully.");
    }
}
