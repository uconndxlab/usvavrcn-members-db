<div class="container my-4">
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-header text-center">
            <h3 class="mb-0">{{ $title ?? 'Create Profile' }}</h3>
        </div>
        <div class="card-body">

            <h3 class="pb-2">Personal Information</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">First Name</label>
                    <input name="first_name" placeholder="First Name" value="{{ old('first_name', $entity->first_name ?? '') }}" 
                           class="form-control @error('first_name') is-invalid @enderror">
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Last Name</label>
                    <input name="last_name" placeholder="Last Name" value="{{ old('last_name', $entity->last_name ?? '') }}" 
                           class="form-control @error('last_name') is-invalid @enderror">
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Entity Type</label>
                    <select name="entity_type" class="form-select @error('entity_type') is-invalid @enderror">
                        <option value="person" @selected(old('entity_type', $entity->entity_type ?? '') === 'person')>Person</option>
                        <option value="group" @selected(old('entity_type', $entity->entity_type ?? '') === 'group')>Group</option>
                    </select>
                    @error('entity_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Email</label>
                    <input name="email" type="email" placeholder="Email" value="{{ old('email', $entity->email ?? '') }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Phone</label>
                    <input name="phone" type="tel" placeholder="Phone" value="{{ old('phone', $entity->phone ?? '') }}" 
                           class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Website</label>
                    <input name="website" placeholder="Website" value="{{ old('website', $entity->website ?? '') }}" 
                           class="form-control @error('website') is-invalid @enderror">
                    @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Biography</label>
                    <textarea name="biography" placeholder="Biography" rows="4" 
                              class="form-control @error('biography') is-invalid @enderror">{{ old('biography', $entity->biography ?? '') }}</textarea>
                    @error('biography')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h4 class="mb-3 mt-5">Professional Information</h4>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Job Title</label>
                    <input name="job_title" placeholder="Job Title" value="{{ old('job_title', $entity->job_title ?? '') }}"
                        class="form-control">
                </div>
                
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Company</label>
                    <input name="company" placeholder="Company" value="{{ old('company', $entity->company ?? '') }}"
                        class="form-control">
                </div>
                
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Career Stage</label>
                    <select name="career_stage" class="form-select">
                        <option value="">Select Career Stage</option>
                        <option value="undergraduate" @selected(old('career_stage', $entity->career_stage ?? '') === 'undergraduate')>Undergraduate</option>
                        <option value="graduate" @selected(old('career_stage', $entity->career_stage ?? '') === 'graduate')>Graduate Student</option>
                        <option value="postdoc" @selected(old('career_stage', $entity->career_stage ?? '') === 'postdoc')>Postdoc</option>
                        <option value="early_career" @selected(old('career_stage', $entity->career_stage ?? '') === 'early_career')>Early Career</option>
                        <option value="mid_career" @selected(old('career_stage', $entity->career_stage ?? '') === 'mid_career')>Mid Career</option>
                        <option value="senior" @selected(old('career_stage', $entity->career_stage ?? '') === 'senior')>Senior</option>
                    </select>
                </div>
                
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Primary Institution</label>
                    <input name="primary_institution_name"
                        placeholder="Primary Institution"
                        value="{{ old('primary_institution_name', $entity->primary_institution_name ?? '') }}"
                        class="form-control">
                </div>
                
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Affiliation</label>
                    <select name="affiliation" class="form-select">
                        <option value="">Select Affiliation</option>
                        <option value="academic" @selected(old('affiliation', $entity->affiliation ?? '') === 'academic')>Academic</option>
                        <option value="industry" @selected(old('affiliation', $entity->affiliation ?? '') === 'industry')>Industry</option>
                        <option value="government" @selected(old('affiliation', $entity->affiliation ?? '') === 'government')>Government</option>
                        <option value="nonprofit" @selected(old('affiliation', $entity->affiliation ?? '') === 'nonprofit')>Non-profit</option>
                    </select>
                </div>
                
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Funding</label>
                    <select name="funding_sources" class="form-select">
                        <option value="">Select Primary Funding</option>
                        <option value="nih" @selected(old('funding_sources', $entity->funding_sources ?? '') === 'nih')>NIH</option>
                        <option value="nsf" @selected(old('funding_sources', $entity->funding_sources ?? '') === 'nsf')>NSF</option>
                        <option value="usda" @selected(old('funding_sources', $entity->funding_sources ?? '') === 'usda')>USDA</option>
                        <option value="private" @selected(old('funding_sources', $entity->funding_sources ?? '') === 'private')>Private</option>
                        <option value="other" @selected(old('funding_sources', $entity->funding_sources ?? '') === 'other')>Other</option>
                    </select>
                </div>
            </div>

            <h4 class="mb-3 mt-5">Research</h4>
            <div class="row g-3">
                <div class="col-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Research Interests</label>
                    <textarea name="research_interests" placeholder="Research Interests" rows="3" class="form-control">{{ old('research_interests', $entity->research_interests ?? '') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Projects</label>
                    <textarea name="projects" placeholder="Projects" rows="3" class="form-control">{{ old('projects', $entity->projects ?? '') }}</textarea>
                </div>
            </div>

            @if(isset($tagCategories) && $tagCategories->count() > 0)
                <h4 class="mb-3 mt-5">Groups & Tags</h4>
                
                @foreach($tagCategories as $category)
                    <div class="mb-4">
                        <h6 class="mb-2" style="color: {{ $category->color ?? '#6c757d' }}">{{ $category->name }}</h6>
                        <p class="text-muted small mb-2">{{ $category->description }}</p>
                        
                        <div class="row">
                            @foreach($category->activeTags as $tag)
                                
                                @php $isTags = str_contains(strtolower($category->name), 'tags');  @endphp
                                @if($isTags)
                                    <div class="col-auto mb-2">
                                        <input class="btn-check" type="checkbox" 
                                            name="tags[]" 
                                            id="tag_{{ $tag->id }}" 
                                            value="{{ $tag->id }}"
                                            @checked(in_array($tag->id, old('tags', $selectedTags ?? [])))>
                                        <label class="btn btn-outline-primary btn-sm py-1 px-2" for="tag_{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                @else
                                    <div class="col-md-12 mb-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                name="tags[]" 
                                                id="tag_{{ $tag->id }}" 
                                                value="{{ $tag->id }}"
                                                @checked(in_array($tag->id, old('tags', $selectedTags ?? [])))>
                                            <label class="form-check-label" for="tag_{{ $tag->id }}">
                                                {{ $tag->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            <h4 class="mb-3 mt-5">Image & Timestamps</h4>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Photo Source</label>
                    <input name="photo_src" placeholder="Photo Source" value="{{ old('photo_src', $entity->photo_src ?? '') }}"
                        class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Creation Date</label>
                    <input name="creation_date" type="datetime-local"
                        value="{{ old('creation_date', $entity->creation_date ?? '') }}" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="small ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">Last Updated</label>
                    <input name="last_updated" type="datetime-local"
                        value="{{ old('last_updated', $entity->last_updated ?? '') }}" class="form-control">
                </div>
            </div>

            @if (isset($entity) && $entity->entity_type === 'group' || old('entity_type') === 'group')
                <hr class="my-4">
                <h4 class="mb-3 text-primary">Group Members</h4>
                <div id="group-members-section"
                    style="max-height: 250px; overflow-y: auto; border: 1px solid #ced4da; border-radius: .375rem; padding: 0.75rem;">
                    @if(isset($allPeople))
                        @foreach ($allPeople as $person)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="members[]"
                                    id="member_{{ $person->id }}" value="{{ $person->id }}"
                                    @checked(in_array($person->id, old('members', $selectedMembers ?? [])))>
                                <label class="form-check-label" for="member_{{ $person->id }}">
                                    {{ $person->name }}
                                </label>
                            </div>
                        @endforeach
                    @endif
                </div>
                <small class="text-muted">Check all members that belong to this group.</small>
            @endif

            @if ($submitButton)
                <button type="submit" class="btn btn-primary mt-4 w-100 py-3 text-uppercase">{{ $submitText }}</button>
            @endif
        </div>
    </div>
</div>

<script>
// Show/hide group members section based on entity type
document.addEventListener('DOMContentLoaded', function() {
    const entityTypeSelect = document.querySelector('select[name="entity_type"]');
    const groupMembersSection = document.getElementById('group-members-section');
    
    if (entityTypeSelect && groupMembersSection) {
        function toggleGroupMembers() {
            const isGroup = entityTypeSelect.value === 'group';
            groupMembersSection.parentElement.style.display = isGroup ? 'block' : 'none';
        }
        
        // Initial check
        toggleGroupMembers();
        
        // Listen for changes
        entityTypeSelect.addEventListener('change', toggleGroupMembers);
    }
});
</script>
