<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;

class GroupMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all groups and people
        $groups = Entity::where('entity_type', 'group')->get();
        $people = Entity::where('entity_type', 'person')->get();

        if ($groups->isEmpty() || $people->isEmpty()) {
            $this->command->info('No groups or people found to assign memberships.');
            return;
        }

        // Assign some random people to each group
        foreach ($groups as $group) {
            // Randomly assign 2-5 people to each group
            $memberCount = rand(2, min(5, $people->count()));
            $randomPeople = $people->random($memberCount);
            
            $group->members()->sync($randomPeople->pluck('id')->toArray());
            
            $this->command->info("Assigned {$memberCount} members to group: {$group->name}");
        }

        $this->command->info('Group memberships assigned successfully.');
    }
}
