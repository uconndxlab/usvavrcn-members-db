<div class="container my-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Name</label>
                <input name="name" value="{{ old('name', $entity->name ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="entity_type" class="form-label">Entity Type</label>
                <select name="entity_type" class="form-select">
                    <option value="person" @selected(old('entity_type', $entity->entity_type ?? '') === 'person')>Person</option>
                    <option value="group" @selected(old('entity_type', $entity->entity_type ?? '') === 'group')>Group</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" value="{{ old('email', $entity->email ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input name="phone" value="{{ old('phone', $entity->phone ?? '') }}" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description', $entity->description ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label for="coe_affiliation" class="form-label">COE Affiliation</label>
                <input name="coe_affiliation" value="{{ old('coe_affiliation', $entity->coe_affiliation ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="lab_group" class="form-label">Lab Group</label>
                <input name="lab_group" value="{{ old('lab_group', $entity->lab_group ?? '') }}" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label for="research_interests" class="form-label">Research Interests</label>
                <textarea name="research_interests" class="form-control">{{ old('research_interests', $entity->research_interests ?? '') }}</textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label for="projects" class="form-label">Projects</label>
                <textarea name="projects" class="form-control">{{ old('projects', $entity->projects ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label for="linkedin" class="form-label">LinkedIn</label>
                <input name="linkedin" value="{{ old('linkedin', $entity->linkedin ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="job_title" class="form-label">Job Title</label>
                <input name="job_title" value="{{ old('job_title', $entity->job_title ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="primary_institution_name" class="form-label">Primary Institution Name</label>
                <input name="primary_institution_name" value="{{ old('primary_institution_name', $entity->primary_institution_name ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="primary_institution_department" class="form-label">Primary Institution Department</label>
                <input name="primary_institution_department" value="{{ old('primary_institution_department', $entity->primary_institution_department ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="primary_institution_mailing" class="form-label">Primary Institution Mailing</label>
                <input name="primary_institution_mailing" value="{{ old('primary_institution_mailing', $entity->primary_institution_mailing ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="secondary_institution_name" class="form-label">Secondary Institution Name</label>
                <input name="secondary_institution_name" value="{{ old('secondary_institution_name', $entity->secondary_institution_name ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="website" class="form-label">Website</label>
                <input name="website" value="{{ old('website', $entity->website ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="career_stage" class="form-label">Career Stage</label>
                <input name="career_stage" value="{{ old('career_stage', $entity->career_stage ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="photo_src" class="form-label">Photo Source</label>
                <input name="photo_src" value="{{ old('photo_src', $entity->photo_src ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="creation_date" class="form-label">Creation Date</label>
                <input name="creation_date" type="datetime-local" value="{{ old('creation_date', $entity->creation_date ?? '') }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="last_updated" class="form-label">Last Updated</label>
                <input name="last_updated" type="datetime-local" value="{{ old('last_updated', $entity->last_updated ?? '') }}" class="form-control">
            </div>
        </div>
</div>
