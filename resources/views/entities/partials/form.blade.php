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
                    <label class="form-label">Description</label>
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
                    <label class="form-label">Institution Mailing Address</label>
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
                    <input name="career_stage" value="{{ old('career_stage', $entity->career_stage ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">LinkedIn</label>
                    <input name="linkedin" value="{{ old('linkedin', $entity->linkedin ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Website</label>
                    <input name="website" value="{{ old('website', $entity->website ?? '') }}" class="form-control">
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
                    <label class="form-label">Photo Source</label>
                    <input name="photo_src" value="{{ old('photo_src', $entity->photo_src ?? '') }}" class="form-control">
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
