#!/usr/bin/env bash
# ---------------------------------------------------------------------------
# export_seed_data.sh
#
# Exports the current database into CSV seed files under
# database/seeders/data/  so they can be committed and used by new developers.
#
# Usage (from the project root):
#   bash database/seeders/export_seed_data.sh [path/to/database.sqlite]
#
# If no argument is given it defaults to database/database.sqlite.
# ---------------------------------------------------------------------------

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../.." && pwd)"
DATA_DIR="$SCRIPT_DIR/data"

DB="${1:-$PROJECT_ROOT/database/database.sqlite}"

if [[ ! -f "$DB" ]]; then
    echo "ERROR: SQLite database not found at: $DB" >&2
    exit 1
fi

mkdir -p "$DATA_DIR"

run_query() {
    local outfile="$1"
    local sql="$2"
    sqlite3 -header -csv "$DB" "$sql" > "$outfile"
    local rows
    rows=$(( $(wc -l < "$outfile") - 1 ))
    echo "  wrote $rows rows → $outfile"
}

echo "Exporting seed data from: $DB"
echo

# ---------------------------------------------------------------------------
# entities
# Excludes session/timestamp columns that Laravel manages automatically
# (created_at, updated_at, profile_completed_at).
# ---------------------------------------------------------------------------
run_query "$DATA_DIR/entities.csv" "
SELECT
    id, entity_type, name, first_name, last_name,
    email, phone,
    job_title, career_stage,
    coe_affiliation, affiliation,
    primary_institution_name, primary_institution_department,
    primary_institution_mailing, secondary_institution_name,
    company, lab_group,
    description, biography, research_interests, expertise,
    projects, publications, awards,
    funding_sources,
    address, city, state, country, postal_code,
    website, linkedin, photo_src, social_links,
    is_public, allow_contact, status,
    creation_date, last_updated
FROM entities
ORDER BY id;
"

# ---------------------------------------------------------------------------
# tag_categories
# ---------------------------------------------------------------------------
run_query "$DATA_DIR/tag_categories.csv" "
SELECT id, name, slug, description, color, sort_order, is_active
FROM tag_categories
ORDER BY sort_order, id;
"

# ---------------------------------------------------------------------------
# tags
# ---------------------------------------------------------------------------
run_query "$DATA_DIR/tags.csv" "
SELECT id, name, slug, description, tag_category_id, parent_tag_id,
       color, sort_order, is_active, metadata
FROM tags
ORDER BY tag_category_id, sort_order, id;
"

# ---------------------------------------------------------------------------
# entity_tag  (which entities carry which tags)
# ---------------------------------------------------------------------------
run_query "$DATA_DIR/entity_tag.csv" "
SELECT entity_id, tag_id
FROM entity_tag
ORDER BY entity_id, tag_id;
"

# ---------------------------------------------------------------------------
# entity_group  (group memberships)
# ---------------------------------------------------------------------------
run_query "$DATA_DIR/entity_group.csv" "
SELECT entity_id, group_id
FROM entity_group
ORDER BY group_id, entity_id;
"

echo
echo "Done. Files written to $DATA_DIR"
