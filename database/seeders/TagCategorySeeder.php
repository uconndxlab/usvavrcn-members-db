<?php

namespace Database\Seeders;

use App\Models\TagCategory;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Team Groups',
                'slug' => 'team-groups',
                'description' => 'Groups representing different research teams',
                'color' => '#3B82F6',
                'sort_order' => 1,
                'tags' => [
                    'Team: Alpha',
                    'Team: Beta', 
                    'Team: Gamma',
                    'Team: Brucellae',
                    'Team: Toxins',
                    'Team: Aquaculture',
                    'Team: Immunology',
                    'Team: Vaccine Technologies'
                ]
            ],
            [
                'name' => 'Focus Groups',  
                'slug' => 'focus-groups',
                'description' => 'Specialized focus areas and research priorities',
                'color' => '#10B981',
                'sort_order' => 2,
                'tags' => [
                    'Focus: Companion animals',
                    'Focus: Wildlife',
                    'Focus: Swine',
                    'Focus: Equines',
                    'Focus: Finishes',
                    'Focus: Hunting',
                    'Focus: Academic',
                    'Focus: Basic Science'
                ]
            ],
            [
                'name' => 'Committee Groups',
                'slug' => 'committee-groups', 
                'description' => 'Administrative and organizational committees',
                'color' => '#8B5CF6',
                'sort_order' => 3,
                'tags' => [
                    'Committee: Fundraising',
                    'Committee: Outreach',
                    'Committee: Nutrition Events',
                    'Committee: Working Group Team Leader'
                ]
            ],
            [
                'name' => 'Host Species Tags',
                'slug' => 'host-species',
                'description' => 'Host species being studied or targeted',
                'color' => '#F59E0B',
                'sort_order' => 4,
                'tags' => [
                    'Avian',
                    'General Avian',
                    'Poultry',
                    'Equine',
                    'General Equine',
                    'Human',
                    'Cattle',
                    'General Bovines',
                    'Small Ruminants'
                ]
            ],
            [
                'name' => 'Pathogen Tags',
                'slug' => 'pathogens',
                'description' => 'Pathogens and disease agents of study',
                'color' => '#EF4444',
                'sort_order' => 5,
                'tags' => [
                    'Viruses',
                    'General Viruses',
                    'Salmonella',
                    'Clostridium',
                    'Chicken diseases',
                    'General',
                    'General Bacteria',
                    'Aerococcus',
                    'Bacteria',
                    'General Bacterial',
                    'Brucella'
                ]
            ],
            [
                'name' => 'Discipline/Stage of Vaccine Development Tags',
                'slug' => 'vaccine-development',
                'description' => 'Stages and disciplines in vaccine development process',
                'color' => '#06B6D4',
                'sort_order' => 6,
                'tags' => [
                    'Discovery',
                    'General: Discovery',
                    'General: Industrial',
                    'Bio-manufacturing',
                    'Vaccine Testing',
                    'General Vaccine Testing',
                    'Clinical Trials'
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $tags = $categoryData['tags'];
            unset($categoryData['tags']);
            
            $category = TagCategory::create($categoryData);
            
            foreach ($tags as $index => $tagName) {
                Tag::create([
                    'name' => $tagName,
                    'slug' => str($tagName)->slug(),
                    'tag_category_id' => $category->id,
                    'sort_order' => $index + 1,
                    'is_active' => true
                ]);
            }
        }
    }
}
