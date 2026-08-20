# ViberLink LMS

## Short Description
Web-Based Learning Management System (LMS) for Fiber To The Home (FTTH) technicians. The platform combines structured learning materials, module-based quizzes, hands-on FTTH simulations, and participant progress monitoring in a single web application.

## Overview
The primary goal of ViberLink LMS is to provide an integrated learning environment for technicians who need to understand both the theoretical and practical aspects of FTTH network installation.

The platform is organized around three core learning components:

1. **Learning Materials**: Provides module-based theoretical learning content, including descriptions and optional video references.
2. **Competency Evaluation**: Provides multiple-choice quizzes for each FTTH learning module and stores the participant's highest score.
3. **Practical Simulation**: Provides interactive FTTH simulation/game scenarios that allow participants to complete practical tasks and record module completion progress.

An administrative workspace is also provided to manage participants, learning materials, quizzes, and overall participant progress.

## Key Features

### Authentication & User Management
- Session-based login and logout
- Separate user roles for **Admin** and **Peserta**
- Username-based authentication
- Password hashing using Laravel's hashing system
- Automatic redirect based on authentication and user role
- Automatic session regeneration after successful login
- Session invalidation and CSRF token regeneration during logout

### Admin Dashboard
- Participant progress monitoring
- Total participant summary
- Completed mission count
- Incomplete mission count
- Participant progress table for all five learning modules
- Participant management
- Participant creation, editing, deletion, and progress reset

### Learning Management System
The LMS is divided into five FTTH learning modules:

- **OLT** — Optical Line Terminal
- **ODC** — Optical Distribution Cabinet
- **ODP** — Optical Distribution Point
- **ONT** — Optical Network Terminal
- **Splicing** — Fiber optic splicing

For each module, participants can:
- Open module details
- Read available learning materials
- Access module quizzes
- View their highest quiz score
- Launch the corresponding practical simulation
- Track practical task completion status

### Learning Materials
- CRUD management for learning materials
- Module assignment
- Material title and description
- Optional video URL
- Configurable material ordering
- Paginated administration interface

### Quiz & Evaluation System
- CRUD management for multiple-choice questions
- Four answer options per question
- Configurable correct answer
- Module-based question bank
- Automatic score calculation
- Highest-score persistence for each participant and module
- Quiz submission through a dedicated POST route

### Practical FTTH Simulation
- Interactive simulation/game pages
- Module-specific simulation scenarios
- Supported simulation categories:
  - OLT
  - ODC
  - ODP
  - ONT
  - Kabel / Splicing
- FTTH device data provided as structured database records
- Completion state persisted per participant and module
- JSON endpoint for marking a practical task as completed

### Participant Progress Tracking
Participant progress is tracked independently for the five core modules:

`OLT` → `ODC` → `ODP` → `ONT` → `Splicing`

Each module can have one of two practical task states:
- `Belum Selesai`
- `Selesai`

The Admin dashboard aggregates these records to determine participant completion status.

## Learning Flow

### Participant Learning Flow
`Login` → `Participant Dashboard` → `Select Module` → `Learning Material` → `Quiz` → `Practical Simulation` → `Module Progress Updated`

The platform keeps the quiz result and practical simulation completion as separate learning outcomes, allowing both theoretical evaluation and practical task completion to be monitored independently.

### Admin Flow
`Login` → `Admin Dashboard` → `Participant Monitoring / Content Management`

The administrator can manage participant accounts, maintain the learning material catalog, maintain the quiz bank, and reset participant practical progress.

## FTTH Device Knowledge Base

The database seeder includes an ordered FTTH device/component knowledge base used by the simulation environment:

1. **Optical Line Terminal (OLT)**
2. **Kabel Feeder**
3. **Optical Distribution Cabinet (ODC)**
4. **Kabel Distribusi**
5. **Optical Distribution Point (ODP)**
6. **Drop Core**
7. **Optical Network Terminal (ONT)**

Each device can contain:
- Device name
- Device type
- Asset image reference
- Full description
- Main function
- Display/simulation ordering

## Tech Stack

### Backend
- PHP 8.2+
- Laravel 12
- Laravel Blade
- Laravel Eloquent ORM

### Frontend
- Blade Templates
- Vite
- Tailwind CSS 4
- Custom CSS design system
- Lucide Icons
- Google Fonts (Roboto)

### Database
- SQLite
- Laravel migrations
- Eloquent models
- Database seeders

### Development & Utilities
- Composer
- npm
- Laravel Tinker
- PHPUnit
- Laravel Pint
- Laravel Pail
- Laravel Sail
- Concurrent development processes via `concurrently`

### Additional Installed Packages
- `barryvdh/laravel-dompdf`
- `maatwebsite/excel`

These packages are installed as project dependencies for document/PDF and spreadsheet-related capabilities.

## Database Design

The application uses SQLite as its default database, making the project portable and eliminating the requirement for a separate MySQL server during local development.

### Core Tables

| Table | Purpose |
|---|---|
| `pengguna` | Stores Admin and Peserta accounts |
| `perangkat_ftth` | Stores FTTH device/component data |
| `progress_modul` | Stores practical task progress per participant and module |
| `materi` | Stores learning materials |
| `kuis` | Stores multiple-choice quiz questions |
| `nilai_kuis` | Stores the highest quiz score per participant and module |
| `sessions` | Stores Laravel session data |
| `password_reset_tokens` | Stores password reset tokens |

### Key Relationships

```text
pengguna
   │
   ├──< progress_modul
   │
   └──< nilai_kuis

materi
   └── belongs to a learning module

kuis
   └── belongs to a learning module

perangkat_ftth
   └── ordered knowledge base for practical simulation
```

## API / Route Overview

The application is primarily a server-rendered Laravel web application. Instead of a separate REST API layer, application interactions are exposed through Laravel web routes.

| Method | Endpoint | Access | Purpose |
|---|---|---|---|
| GET | `/` | Guest / Authenticated | Redirects guests to login and authenticated users to the appropriate landing page |
| GET | `/login` | Public | Display login form |
| POST | `/login` | Public | Authenticate user |
| POST | `/logout` | Authenticated | Logout and invalidate session |
| GET | `/modul/{nama_modul}` | Authenticated | Display module detail |
| GET | `/modul/{nama_modul}/materi` | Authenticated | Display module learning materials |
| GET | `/modul/{nama_modul}/kuis` | Authenticated | Display module quiz |
| POST | `/modul/{nama_modul}/kuis/submit` | Authenticated | Submit quiz and calculate score |
| GET | `/simulasi/game/{kategori?}` | Authenticated | Open practical simulation |
| POST | `/api/selesaikan-tugas` | Authenticated | Mark practical task as completed |
| GET | `/admin/dashboard` | Authenticated | Display administrator dashboard |
| GET/POST | `/admin/peserta` | Authenticated | List and create participants |
| GET | `/admin/peserta/{id}/edit` | Authenticated | Open participant edit page |
| PUT | `/admin/peserta/{id}` | Authenticated | Update participant |
| DELETE | `/admin/peserta/{id}` | Authenticated | Delete participant |
| POST | `/admin/peserta/{id}/reset` | Authenticated | Reset participant progress |
| Resource | `/admin/materi/*` | Authenticated | Material management |
| Resource | `/admin/kuis/*` | Authenticated | Quiz management |

## Project Structure

```text
viberlink-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php
│   │   │   ├── KuisController.php
│   │   │   ├── LMSController.php
│   │   │   ├── MateriController.php
│   │   │   └── SimulasiGameController.php
│   │   └── Middleware/
│   │       ├── CheckRoleAdmin.php
│   │       └── CheckRoleTeknisi.php
│   └── Models/
│       ├── Kuis.php
│       ├── Materi.php
│       ├── NilaiKuis.php
│       ├── Pengguna.php
│       ├── PerangkatFtth.php
│       └── ProgressModul.php
│
├── database/
│   ├── database.sqlite
│   ├── migrations/
│   │   └── 2026_01_01_000000_create_core_tables.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── DummyDataSeeder.php
│
├── public/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── app.js
│   └── index.php
│
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── peserta/
│       ├── simulasi/
│       ├── teknisi/
│       └── layouts/
│
├── routes/
│   ├── console.php
│   └── web.php
│
├── storage/
├── composer.json
├── package.json
└── vite.config.js
```

## Environment Configuration

The project uses environment variables managed through Laravel's `.env` file.

The default database configuration is:

```env
DB_CONNECTION=sqlite
```

Laravel's SQLite database file is located at:

```text
database/database.sqlite
```

A project-specific `.env.example` is included as the starting point for local configuration.

Important environment variables include:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120

QUEUE_CONNECTION=database
CACHE_STORE=database
```

Do not commit a real `.env` file or other environment-specific secrets to version control.

## Default Demo Accounts

The default `DatabaseSeeder` creates the following demonstration accounts:

| Role | Username | Password |
|---|---|---|
| Admin | `admin` | `admin123` |
| Peserta | `teknisi` | `teknisi123` |

These credentials are intended for local/demo environments and should be changed before any production deployment.

## Database Seeding

The main `DatabaseSeeder` creates:
- One Administrator account
- One Participant account
- Initial progress records for all five modules
- FTTH device/component data

The `DummyDataSeeder` can be used to generate:
- 10 learning materials for each module
- 10 quiz questions for each module

This results in up to 50 dummy learning materials and 50 dummy quiz questions across the five modules when the dummy seeder is executed.

## Installation & Local Development

### Prerequisites

- PHP 8.2 or newer
- Composer
- Node.js and npm
- SQLite support enabled in PHP
- A modern web browser

### 1. Clone the Repository

```bash
git clone <repository-url>
cd viberlink-app
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Configure Environment

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Make sure the environment contains:

```env
DB_CONNECTION=sqlite
```

Ensure the SQLite database file exists:

```text
database/database.sqlite
```

### 5. Run Database Migrations

```bash
php artisan migrate
```

### 6. Seed Initial Data

```bash
php artisan db:seed
```

The command creates the default demo accounts, initial participant progress records, and FTTH device data.

To generate additional dummy learning materials and quiz questions:

```bash
php artisan db:seed --class=DummyDataSeeder
```

### 7. Run the Application

Start the Laravel development server:

```bash
php artisan serve
```

The application will normally be available at:

```text
http://localhost:8000
```

### 8. Frontend Development Mode

In a separate terminal:

```bash
npm run dev
```

### 9. Production Asset Build

```bash
npm run build
```

## UI & Design System

The current application uses a custom CSS design system centered around a modern, minimal interface.

### Visual Characteristics
- Red primary accent inspired by the project's branding
- Neutral gray and near-black typography
- White/light application background
- Glass-style panels and cards
- Rounded buttons and cards
- Responsive layout
- Roboto typography
- Lucide iconography
- Subtle fade-in transitions
- Color-coded learning categories

### Learning Category Indicators

The module detail interface visually separates learning activities:

- **Red** — Learning Materials
- **Yellow** — Quiz / Evaluation
- **Green** — Practical Simulation

This visual hierarchy allows participants to distinguish theoretical learning, assessment, and practical training at a glance.

## Security & Application Controls

The application includes several standard Laravel security mechanisms:

- Password hashing through Laravel's `Hash` facade
- Session-based authentication
- Session regeneration after login
- Session invalidation after logout
- CSRF protection through Laravel forms and CSRF tokens
- Server-side request validation
- Unique username validation for participant management
- Route grouping through Laravel middleware
- Hidden password attributes in the `Pengguna` model
- Environment-based application configuration
- SQLite database kept inside the application's database directory for local portability

The project also contains role middleware classes for administrator and technician-oriented access checks.

## Routing Behavior

The root route (`/`) acts as the application's entry point:

```text
Guest
  └── / → /login

Authenticated Admin
  └── / → /admin/dashboard

Authenticated Participant
  └── / → Participant dashboard
```

The login process also redirects users according to their stored role.

## Development Commands

Common commands used during development include:

```bash
# Start Laravel development server
php artisan serve

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Generate application key
php artisan key:generate

# Clear Laravel caches
php artisan optimize:clear

# Run Laravel tests
php artisan test

# Run code formatting
./vendor/bin/pint

# Start Vite development server
npm run dev

# Build frontend assets
npm run build
```

The project also defines a Composer development workflow:

```bash
composer run dev
```

This command runs Laravel, the queue listener, Laravel Pail, and Vite concurrently.

## Testing & Validation

The repository includes PHPUnit/Laravel test infrastructure under the `tests/` directory.

At the time this README was prepared, the included test suite could not be executed successfully in the inspection environment because the PHP `mbstring` extension was unavailable:

```text
Call to undefined function Illuminate\Support\mb_split()
```

This is an environment dependency issue rather than a documented application test result. A local development environment should enable the PHP `mbstring` extension before running:

```bash
php artisan test
```

## Architecture Highlights

This project demonstrates several practical full-stack web development concepts:

- **Laravel MVC Architecture**: Separates routing, controllers, models, and Blade presentation.
- **Server-Rendered LMS**: Uses Blade templates for the primary application interface.
- **SQLite Portability**: Removes the need for a separate MySQL server during local deployment.
- **Module-Based Learning**: Organizes FTTH training into five clearly defined competency areas.
- **Dual Learning Assessment**: Combines theoretical quiz evaluation with practical simulation completion.
- **Progress Tracking**: Stores participant progress per module and provides administrative reporting.
- **Seed-Driven Development**: Provides reproducible demo users, FTTH device data, and optional dummy LMS content.
- **Custom UI System**: Uses reusable CSS variables, cards, buttons, badges, tables, and visual states to maintain interface consistency.

## Current Limitations / Future Improvements

The current implementation can be extended in several areas:

- **Stricter Role Middleware Application**: Apply the existing role middleware directly to administrator and participant route groups to enforce role authorization at the routing layer.
- **Automated Test Coverage**: Expand the current Laravel test suite beyond the default example tests into authentication, quiz scoring, progress updates, and administrator workflows.
- **Content-Rich Learning Materials**: Extend the material model and UI to support richer media/content management beyond title, description, ordering, and video URL.
- **Dedicated Simulation Domain Model**: Move more simulation-specific rules into dedicated services/models as the simulation becomes more complex.
- **Production Deployment Hardening**: Add production environment configuration, stronger secret management, HTTPS enforcement, and infrastructure-specific deployment documentation.
- **Database Constraints**: Add additional unique/index constraints where needed to prevent duplicate participant-module progress and duplicate quiz score records.
- **Role Model Expansion**: Formalize the role system if the application later requires additional technician roles or granular permissions.

## Portfolio / Academic Context

ViberLink LMS was developed as an academic and technical project focused on digital learning for FTTH network technicians.

The project demonstrates the application of modern web development practices to a domain-specific training platform, combining:

- Learning Management System functionality
- Authentication and user management
- Administrative reporting
- Structured FTTH learning content
- Quiz-based competency evaluation
- Practical network installation simulation
- Persistent participant progress tracking
- Portable SQLite-based local deployment

The system is designed to support a learning journey that connects **FTTH theory → assessment → practical simulation → progress monitoring** within a single application.

## License

This project is developed for academic and educational purposes.

Copyright © 2026.
