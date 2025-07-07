<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h3 class="mb-4 border-bottom pb-2 text-primary">Basic Info</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input name="name" value="{{ old('name', $entity->name ?? '') }}" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Entity Type</label>
                    <select name="entity_type" class="form-select">
                        <option value="person" @selected(old('entity_type', $entity->entity_type ?? '') === 'person')>Person</option>
                        <option value="group" @selected(old('entity_type', $entity->entity_type ?? '') === 'group')>Group</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" value="{{ old('email', $entity->email ?? '') }}" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input name="phone" value="{{ old('phone', $entity->phone ?? '') }}" class="form-control">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Description/Biography</label>
                    <textarea name="description" rows="3" class="form-control">{{ old('description', $entity->description ?? '') }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <h4 class="mb-3 text-primary">Affiliations</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">COE Affiliation</label>
                    <input name="coe_affiliation" value="{{ old('coe_affiliation', $entity->coe_affiliation ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lab Group</label>
                    <input name="lab_group" value="{{ old('lab_group', $entity->lab_group ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Primary Institution</label>
                    <input name="primary_institution_name" value="{{ old('primary_institution_name', $entity->primary_institution_name ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Institution Department</label>
                    <input name="primary_institution_department" value="{{ old('primary_institution_department', $entity->primary_institution_department ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Institution Mailing Address (Address, Town, County, Postcode)</label>
                    <input name="primary_institution_mailing" value="{{ old('primary_institution_mailing', $entity->primary_institution_mailing ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Secondary Institution</label>
                    <input name="secondary_institution_name" value="{{ old('secondary_institution_name', $entity->secondary_institution_name ?? '') }}" class="form-control">
                </div>
            </div>

            <hr class="my-4">

            <h4 class="mb-3 text-primary">Professional Details</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Job Title</label>
                    <input name="job_title" value="{{ old('job_title', $entity->job_title ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Career Stage</label>
                    <select name="career_stage" class="form-select">
                        <option value="none" @selected(old('career_stage', $entity->career_stage ?? '') === 'none')>None</option>
                        <option value="undergraduate" @selected(old('career_stage', $entity->career_stage ?? '') === 'undergraduate')>Undergraduate</option>
                        <option value="postgraduate" @selected(old('career_stage', $entity->career_stage ?? '') === 'postgraduate')>Postgraduate</option>
                        <option value="postdoc" @selected(old('career_stage', $entity->career_stage ?? '') === 'postdoc')>Postdoc</option>
                        <option value="group_leader" @selected(old('career_stage', $entity->career_stage ?? '') === 'group_leader')>Group leader</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">LinkedIn</label>
                    <input name="linkedin" type="url" value="{{ old('linkedin', $entity->linkedin ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Website</label>
                    <input name="website" type="url" value="{{ old('website', $entity->website ?? '') }}" class="form-control">
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Host Species</label>
                    <div style="max-height: 250px; overflow-y: auto; border: 1px solid #ced4da; border-radius: .375rem; padding: 0.75rem;">
                        @php
                            $hostSpeciesOptions = [
                                'poultry' => 'Poultry',
                                'fish' => 'Fish',
                                'cattle' => 'Cattle',
                                'pigs' => 'Pigs',
                                'small_ruminants' => 'Small ruminants',
                                'buffalo' => 'Buffalo',
                                'camels' => 'Camels',
                                'cats' => 'Cats',
                                'dogs' => 'Dogs',
                                'horses' => 'Horses',
                                'wildlife' => 'Wildlife',
                                'zoonoses' => 'Zoonoses',
                            ];
                        @endphp

                        @foreach ($hostSpeciesOptions as $value => $label)
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="host_species[]"
                                    id="host_species_{{ $value }}"
                                    value="{{ $value }}"
                                    @checked(in_array($value, old('host_species', $entity->host_species ?? [])))
                                >
                                <label class="form-check-label" for="host_species_{{ $value }}">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pathogen</label>
                    <div style="max-height: 250px; overflow-y: auto; border: 1px solid #ced4da; border-radius: .375rem; padding: 0.75rem;">
                        @php
                            $pathogenOptions = [
                                'viruses' => 'Viruses',
                                'retroviruses' => 'Retroviruses',
                                'respiratory_syncytial_virus' => 'Respiratory syncytial virus',
                                'rabies_virus' => 'Rabies virus',
                                'rift_valley_fever_virus' => 'Rift Valley fever virus',
                                'rotavirus' => 'Rotavirus',
                                'poxviruses' => 'Poxviruses',
                                'prrsv' => 'Porcine reproductive and respiratory syndrome virus',
                                'capripoxvirus' => 'Capripoxvirus',
                                'calicivirus' => 'Calicivirus',
                                'bovine_viral_diarrhoea' => 'Bovine viral diarrhoea',
                                'chicken_anaemia_virus' => 'Chicken anaemia virus',
                                'classical_swine_fever_virus' => 'Classical swine fever virus',
                                'crimean_congo_fever_virus' => 'Crimean-Congo haemorrhagic fever virus',
                                'coronavirus' => 'Coronavirus',
                                'bovine_ephemeral_fever_virus' => 'Bovine ephemeral fever virus',
                                'bluetongue_virus' => 'Bluetongue virus',
                                'african_swine_fever_virus' => 'African swine fever virus',
                                'african_horse_sickness_virus' => 'African horse sickness virus',
                                'adenovirus' => 'Adenovirus',
                                'arboviruses' => 'Arboviruses',
                                'arteriviruses' => 'Arteriviruses',
                                'avian_polyomavirus' => 'Avian polyomavirus',
                                'avian_papillomavirus' => 'Avian papillomavirus',
                                'cytomegalovirus' => 'Cytomegalovirus',
                                'ebolaviruses' => 'Ebolaviruses/filoviruses',
                                'aeromonas' => 'Aeromonas',
                                'chlamydophila' => 'Chlamydophila',
                                'salmonella' => 'Salmonella',
                                'parasites' => 'Parasites',
                                'nematodes' => 'Nematodes',
                                'cestodes' => 'Cestodes',
                                'ticks' => 'Ticks',
                                'neosporas' => 'Neospora',
                                'eimeria' => 'Eimeria',
                                'babesia' => 'Babesia',
                                'taenia_solium' => 'Taenia solium',
                                'theileria_annulata' => 'Theileria annulata',
                                'trypanosoma' => 'Trypanosoma',
                                'theileria_parva' => 'Theileria parva',
                                'parainfluenza_virus' => 'Parainfluenza virus',
                                'nipah_virus' => 'Nipah virus',
                                'newcastle_disease_virus' => 'Newcastle disease virus',
                                'paramyxoviruses' => 'Paramyxoviruses',
                                'parvovirus' => 'Parvovirus',
                                'piscine_novirhabdovirus' => 'Piscine novirhabdovirus',
                                'pprv' => 'Peste des petits ruminants virus',
                                'nairoviruses' => 'Nairoviruses',
                                'mareks_disease_virus' => 'Mareks disease virus',
                                'herpesvirus' => 'Herpesvirus',
                                'foot_and_mouth_disease_virus' => 'Foot-and-mouth disease virus',
                                'feline_leukaemia_virus' => 'Feline leukaemia virus',
                                'infectious_bursal_disease_virus' => 'Infectious bursal disease virus',
                                'infectious_pancreatic_necrosis_virus' => 'Infectious pancreatic necrosis virus',
                                'influenza_virus' => 'Influenza virus',
                                'infectious_salmon_anaemia_virus' => 'Infectious salmon anaemia virus',
                                'porcine_circovirus' => 'Porcine circovirus',
                                'e_coli' => 'E. coli',
                                'mycoplasma' => 'Mycoplasma',
                                'corynebacterium' => 'Corynebacterium',
                                'erysipelas' => 'Erysipelas',
                                'm_hyo' => 'M. hyo',
                                'mycobacteria_bovis' => 'Mycobacteria bovis',
                                'clostridia' => 'Clostridia',
                                'leptospira' => 'Leptospira',
                                'brucella' => 'Brucella',
                                'yersinia' => 'Yersinia',
                            ];
                        @endphp

                        @foreach ($pathogenOptions as $value => $label)
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="pathogen[]"
                                    id="pathogen_{{ $value }}"
                                    value="{{ $value }}"
                                    @checked(in_array($value, old('pathogen', $entity->pathogen ?? [])))
                                >
                                <label class="form-check-label" for="pathogen_{{ $value }}">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Discipline</label>
                    <div style="max-height: 250px; overflow-y: auto; border: 1px solid #ced4da; border-radius: .375rem; padding: 0.75rem;">
                        @php
                            $disciplineOptions = [
                                'bacteriology' => 'Bacteriology',
                                'bio_manufacturing' => 'Bio-manufacturing',
                                'bioinformatics' => 'Bioinformatics',
                                'cellular_biology' => 'Cellular biology',
                                'challenge_model_development' => 'Challenge model development',
                                'challenge_study_design' => 'Challenge study design',
                                'clinical_trials_efficacy' => 'Clinical trials – efficacy',
                                'clinical_trials_safety' => 'Clinical trials – safety',
                                'commercialisation' => 'Commercialisation',
                                'deployment' => 'Deployment',
                                'economics' => 'Economics',
                                'epidemiology' => 'Epidemiology',
                                'ethics' => 'Ethics',
                                'formulation_technology' => 'Formulation technology',
                                'immunology_b_cells' => 'Immunology – B-cells',
                                'immunology_innate' => 'Immunology – innate',
                                'immunology_t_cells' => 'Immunology – T-cells',
                                'molecular_biology' => 'Molecular biology',
                                'parasitology' => 'Parasitology',
                                'pharmacovigilance' => 'Pharmacovigilance',
                                'protein_biology' => 'Protein biology',
                                'qc_test_development' => 'QC test development',
                                'quality_assurance' => 'Quality assurance',
                                'registration' => 'Registration',
                                'regulation' => 'Regulation',
                                'safety_evaluation' => 'Safety evaluation',
                                'social_sciences' => 'Social sciences',
                                'statistics' => 'Statistics',
                                'structural_biology' => 'Structural biology',
                                'systems_biology' => 'Systems biology',
                                'virology' => 'Virology',
                            ];
                        @endphp

                        @foreach ($disciplineOptions as $value => $label)
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="discipline[]"
                                    id="discipline_{{ $value }}"
                                    value="{{ $value }}"
                                    @checked(in_array($value, old('discipline', $entity->discipline ?? [])))
                                >
                                <label class="form-check-label" for="discipline_{{ $value }}">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stage of Vaccine Development</label>
                    <div style="max-height: 250px; overflow-y: auto; border: 1px solid #ced4da; border-radius: .375rem; padding: 0.75rem;">
                        @php
                            $vaccineStageOptions = [
                                'adjuvants' => 'Adjuvants',
                                'antigen_discovery' => 'Antigen discovery and immunogen design',
                                'clinical_trials' => 'Clinical trials',
                                'commercialisation' => 'Commercialisation',
                                'correlates_of_protection' => 'Correlates of protection – immunomonitoring',
                                'deployment' => 'Deployment',
                                'field_trials' => 'Field trials',
                                'marketing' => 'Marketing',
                                'preclinical_trials' => 'Pre-clinical trials',
                                'vaccine_delivery' => 'Vaccine delivery',
                            ];
                        @endphp

                        @foreach ($vaccineStageOptions as $value => $label)
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="vaccine_stage[]"
                                    id="vaccine_stage_{{ $value }}"
                                    value="{{ $value }}"
                                    @checked(in_array($value, old('vaccine_stage', $entity->vaccine_stage ?? [])))
                                >
                                <label class="form-check-label" for="vaccine_stage_{{ $value }}">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <h4 class="mb-3 text-primary">Research</h4>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Research Interests</label>
                    <textarea name="research_interests" rows="3" class="form-control">{{ old('research_interests', $entity->research_interests ?? '') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Projects</label>
                    <textarea name="projects" rows="3" class="form-control">{{ old('projects', $entity->projects ?? '') }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <h4 class="mb-3 text-primary">Image & Timestamps</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Photo Upload</label>
                    <input name="photo_src" type="file" class="form-control">
                    @if (!empty($entity->photo_src))
                        <div>
                            <img src="{{ asset('storage/' . $entity->photo_src) }}" alt="Uploaded Photo">
                        </div>
                        
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Creation Date</label>
                    <input name="creation_date" type="datetime-local" value="{{ old('creation_date', $entity->creation_date ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Updated</label>
                    <input name="last_updated" type="datetime-local" value="{{ old('last_updated', $entity->last_updated ?? '') }}" class="form-control">
                </div>
            </div>

            @if ($entity->entity_type === 'group')
                <hr class="my-4">
                <h4 class="mb-3 text-primary">Group Members</h4>
                <div style="max-height: 250px; overflow-y: auto; border: 1px solid #ced4da; border-radius: .375rem; padding: 0.75rem;">
                    @foreach ($allPeople as $person)
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="members[]"
                                id="member_{{ $person->id }}"
                                value="{{ $person->id }}"
                                @checked(in_array($person->id, old('members', $selectedMembers)))
                            >
                            <label class="form-check-label" for="member_{{ $person->id }}">
                                {{ $person->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Check all members that belong to this group.</small>
            @endif

        </div>
    </div>
</div>
