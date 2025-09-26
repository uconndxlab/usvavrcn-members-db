<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\TagCategory;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TagCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $SORT_ORDER_COUNTER = 1;
        $categories = [
            [
                'name' => 'Host Species Tags',
                'slug' => 'host-species',
                'description' => 'Host species being studied or targeted',
                'color' => '#F59E0B',
                'sort_order' => $SORT_ORDER_COUNTER++,
                'groups_tags' => [
                    'Team: Avian' => [
                        'Poultry',
                    ],
                    'Team: Equine' => [
                        'Horses',
                    ],
                    'Team: Ruminant' => [
                        'Cattle',
                        'Small ruminants',
                        'Buffalo',
                    ],
                    'Team: Swine' => [
                        'Pigs',
                    ],
                    'Team: Aquaculture' => [
                        'Finfish',
                        'Shellfish',
                        'Crustaceans',
                        'Mollusks',
                    ],
                    'Focus: Companion animals' => [
                        'Cats',
                        'Dogs',
                        'Wildlife',
                        'Zoonoses',
                        'Transboundary/Foreign animal disease',
                        'Camels',
                    ],
                ]
            ],
            [
                'name' => 'Pathogen Tags',
                'slug' => 'pathogens',
                'description' => 'Pathogens and disease agents of study',
                'color' => '#EF4444',
                'sort_order' => $SORT_ORDER_COUNTER++,
                'groups_tags' => [
                    'Focus: Viruses' => [
                        'Adenovirus',
                        'African horse sickness',
                        'African swine fever virus',
                        'Arboviruses',
                        'Ateriviruses',
                        'Avian papillomavirus',
                        'Avian polyomavirus',
                        'Bluetongue virus',
                        'Bovine ephemeral fever virus',
                        'Bovine viral diarrhea',
                        'Calicivirus',
                        'Capripoxvirus ',
                        'Chicken anemia virus',
                        'Classical swine fever virus',
                        'Coronavirus',
                        'Crimean-Congo hemorrhagic fever virus',
                        'Cytomegalovirus',
                        'Ebolaviruses/filoviruses',
                        'Feline leukemia virus',
                        'Foot-and-mouth disease virus',
                        'Herpesvirus',
                        'Infectious bursal disease virus',
                        'Infectiouspancreatic necrosis virus',
                        'Infectious salmon anemia virus',
                        'Influenza virus',
                        'Mareks disease virus',
                        'Nairoviruses',
                        'Newcastle disease virus',
                        'Nipah virus',
                        'Parainfluenza virus',
                        'Paramyxoviruses',
                        'Parvovirus',
                        'Peste des petits ruminants virus',
                        'Piscine novirhabdovirus',
                        'Porcine circovirus',
                        'Porcine reproductive and respiratory syndrome virus',
                        'Poxviruses',
                        'Rabies virus',
                        'Respiratory syncytial virus',
                        'Retroviruses',
                        'Rift Valley fever virus',
                        'Rotaviruses',
                    ],
                    'Focus: Bacteria' => [
                        'Aeromonas',
                        'Anaplasma ',
                        'Borrelia ',
                        'Brucella',
                        'Chlamydia ',
                        'Chlamydiophila',
                        'Clostridia',
                        'Corynebacterium',
                        'Coxiella',
                        'Erlichia',
                        'E.coli',
                        'Erysipelas',
                        'Francisella ',
                        'Leptospira',
                        'Mycobacterium avium subsp. paratuberculosis',
                        'Mycoplasma hyopneumoniae (M. hyo)',
                        'Mycoplasma species',
                        'Mycobacteria bovis',
                        'Rickettsia ',
                        'Yersinia',
                        'Salmonella',
                        'Staphylococcus',
                    ]
                ]
            ],
            [
                'name' => 'Discipline/Stage of Vaccine Development Tags',
                'slug' => 'vaccine-development',
                'description' => 'Stages and disciplines in vaccine development process',
                'color' => '#06B6D4',
                'sort_order' => $SORT_ORDER_COUNTER++,
                'groups_tags' => [
                    'Focus: Industrial' => [
                        'Bio-manufacturing',
                        'Commercialisation',
                        'Deployment',
                        'Fund raising, venture capital',
                        'Marketing strategies',
                        'QC test development',
                        'Quality assurance',
                        'Patents',
                        'Registration',
                        'Regulation',
                        'Transition from research to manufacture',
                        'Marketing',
                    ],
                    'Focus: Vaccine testing' => [
                        'Challenge model development',
                        'Challenge study design',
                        'Clinical trails',
                        'Clinical trials - efficacy',
                        'Clinical trials - safety',
                        'Field trails',
                        'Pre-clinical trails',
                        'Safety evaluation',
                    ],
                    'Focus: Academic' => [
                        'Economics',
                        'Epidemiology',
                        'Ethics',
                        'Social sciences',
                        'Statistics',
                    ],
                    'Team: Immunology' => [
                        'Humoral immunity',
                        'Innate immunity',
                        'Cellular immunity',
                        'Allergy',
                        'Correlates of protection-immunomonitoring',
                        'Protective antigens',
                        'Mucosal vaccines',
                        'Cancer vaccines',
                    ],
                    'Team: Basic Science' => [
                        'Bioinformatics',
                        'Cellular biology',
                        'Molecular biology',
                        'Pharmacovigilance',
                        'Protein biology',
                        'Structural biology',
                        'Systems biology',
                    ],
                    'Team: Vaccine technologies' => [
                        'Live-attenuated vaccine',
                        'Adjuvents',
                        'Antigen discovery and immunogen design',
                        'Formulation technology',
                        'Killed vaccines/bacterins',
                        'Mosaic/cross-protective/universal vaccines',
                        'Plant-expressed vaccines',
                        'Subunit vaccines',
                        'Synthetic biology',
                        'Vaccine delivery',
                        'Vector-borne/transmission-blocking vaccines',
                        'DNA/RNA vaccines',
                    ],
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $group_tags = $categoryData['groups_tags'];
            unset($categoryData['groups_tags']);
            
            $category = TagCategory::create($categoryData);

            foreach ($group_tags as $groupName => $group) {
                foreach ($group as $index => $tagName) {
                    $tag = Tag::create([
                        'name' => $tagName,
                        'slug' => str($tagName)->slug(),
                        'tag_category_id' => $category->id,
                        'sort_order' => $index + 1,
                        'is_active' => true
                    ]);

                    $group_entity = Entity::where('name', $groupName)->first();
                    if ($group_entity) {
                        Log::info("Attaching tag: " . $tagName . " to group: " . $groupName);
                        $group_entity->tags()->attach($tag->id);
                    } else {
                        Log::warning("Group entity not found for name: " . $groupName);
                    }
                }
            }
        }

        // These are at the bottom of seed_content_v3.csv 
        $moreCategories = [
            [
                'name' => 'Affiliation',
                'slug' => 'affiliation',
                'color' => '#3B82F6',
                'sort_order' => $SORT_ORDER_COUNTER++,
                'tags' => [
                    'Affiliation: US Government',
                    'Affiliation: State Government',
                    'Affiliation: Industry, Producer',
                    'Affiliation: Industry, vaccines',
                    'Affiliation: Industry, Retail',
                    'Affiliation: Veterinary Clinical',
                    'Affiliation: Academic Extension',
                    'Affiliation: Academic Teaching',
                    'Affiliation: Academic Research',
                    'Affiliation: FILL_IN'
                ]
            ],
            [
                'name' => 'Funding ',
                'slug' => 'funding',
                'color' => '#10B981',
                'sort_order' => $SORT_ORDER_COUNTER++,
                'tags' => [
                    'Funding: USDA',
                    'Funding: NIH',
                    'Funding: NSF',
                    'Funding: NPB',
                    'Funding: US Egg&Poultry',
                    'Funding: Internal',
                    'Funding: USAID',
                    'Funding: Defense',
                    'Funding: DARPA',
                    'Funding: IVVN',
                    'Funding: FILL-IN',
                ]
            ],
        ];

        foreach ($moreCategories as $categoryData) {
            $tags = $categoryData['tags'];
            unset($categoryData['tags']);

            $category = TagCategory::create($categoryData);

            foreach ($tags as $index => $tagName) {
                Tag::firstOrCreate(
                    ['name' => $tagName],
                    [
                        'slug' => str($tagName)->slug(),
                        'tag_category_id' => $category->id,
                        'sort_order' => $index + 1,
                        'is_active' => true
                    ]
                );
            }
        }
    }
}
