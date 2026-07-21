# USAVRCN Members Directory

A Laravel + Livewire member directory application for the US Animal Vaccine Research Collaborative Network (USAVRCN). It tracks member entities (people and groups), tag categories, tags, and group memberships.

## Requirements

- PHP 8.3+
- Composer
- SQLite (bundled with PHP on most systems)

## Getting Started

### 1. Clone and install dependencies

```bash
git clone <repo-url>
cd usvavrcn-members-db
composer install
```

### 2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

The default configuration uses SQLite with no additional setup required. The database file will be created automatically at `database/database.sqlite`.

### 3. Run migrations

```bash
php artisan migrate
```

### 4. Seed the database

Seed data is stored as CSV files in `database/seeders/data/` and covers entities (people and groups), tag categories, tags, and all pivot relationships.

```bash
php artisan db:seed
```

This runs the following seeders in order:

| Seeder | Source file | What it loads |
|---|---|---|
| `EntitySeeder` | `data/entities.csv` | People and group entities |
| `TagCategorySeeder` | `data/tag_categories.csv` | Tag categories |
| `TagSeeder` | `data/tags.csv` | Individual tags |
| `EntityTagSeeder` | `data/entity_tag.csv` | Entity ↔ tag assignments |
| `EntityGroupSeeder` | `data/entity_group.csv` | Group memberships |

To start completely fresh (drops and recreates all tables, then seeds):

```bash
php artisan migrate:fresh --seed
```

### 5. Start the development server

```bash
php artisan serve
```

The application will be available at <http://localhost:8000>.

---

## Updating the Seed Data

When you have a new production database and want to regenerate the CSV seed files from it, run:

```bash
bash database/seeders/export_seed_data.sh [path/to/database.sqlite]
```

If no path is given, it defaults to `database/database.sqlite`. The script exports all relevant tables to `database/seeders/data/` — commit the updated CSVs so other developers get the new data on their next `db:seed`.

---

## Project Structure

```
app/
  Http/Controllers/   – standard Laravel controllers
  Livewire/           – Livewire components (Members, Groups, PostCard, …)
  Models/             – Eloquent models (Entity, Tag, TagCategory, Post, User)
database/
  migrations/         – database schema migrations
  seeders/
    data/             – CSV seed files (committed to version control)
    export_seed_data.sh – script to regenerate CSVs from a live database
    DatabaseSeeder.php
    EntitySeeder.php
    TagCategorySeeder.php
    TagSeeder.php
    EntityTagSeeder.php
    EntityGroupSeeder.php
resources/views/      – Blade templates
routes/web.php        – application routes
```

---

