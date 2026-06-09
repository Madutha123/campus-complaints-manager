# AGENTS.md — Campus Complaints Manager

## Build / Lint / Test Commands

```bash
# Full project setup (fresh clone)
composer run setup          # composer install, .env, key:generate, migrate, npm install, npm build

# Run locally (three concurrent processes: server, queue, vite)
composer run dev

# Lint (auto-fix with Pint)
composer lint               # runs: pint --parallel

# Lint (check only, no fixes)
composer lint:check         # runs: pint --parallel --test

# Run all tests (with lint check first)
composer test               # config:clear → lint:check → php artisan test

# Run tests directly (skip lint)
./vendor/bin/pest

# Run single test file
./vendor/bin/pest tests/Feature/Auth/AuthenticationTest.php

# Run tests matching a name
./vendor/bin/pest --filter="login"

# Run tests in a specific suite (phpunit.xml defines Unit/Feature suites)
php artisan test --testsuite=Feature --filter="login"

# CI check (full test suite)
composer ci:check

# Build frontend assets
npm run build
npm run dev                 # vite dev server
```

**Testing framework:** Pest PHP v4. Uses `test()` and `describe()` functions (not PHPUnit classes).

**Database:** SQLite in-memory for testing (configured in `phpunit.xml`). All feature tests use `RefreshDatabase` (configured in `tests/Pest.php`).

---

## Project Architecture

- **Laravel 13** with **PHP 8.3+**, **Livewire 4**, **Flux 2.12** UI components
- **Role-based** access: `student`, `staff`, `admin` (enforced by `RoleMiddleware`)
- **Auth:** Laravel Fortify — login, register, 2FA, password reset (Livewire-powered views)
- **Frontend:** Tailwind CSS v4, Vite, Flux component library
- **Styling:** `@theme` with zinc palette in `resources/css/app.css`; dark mode via `.dark` variant

### Directory Layout

- `app/` — PSR-4 `App\` namespace
  - `Models/` — Eloquent models
  - `Http/Controllers/{Admin,Staff,Student,Auth}/` — role-separated controllers
  - `Livewire/` — Livewire full-page components (`Settings/`, `Actions/`)
  - `Actions/Fortify/` — Fortify action classes
  - `Concerns/` — Shared validation rule traits
  - `Policies/` — Authorization policies
  - `Http/Middleware/` — `RoleMiddleware`
- `routes/` — `web.php` (all web routes), `settings.php` (Livewire settings), `console.php`
- `resources/views/` — Blade views organized by role (`admin/`, `staff/`, `student/`) and component type
- `tests/` — Pest tests in `Feature/` and `Unit/` directories

---

## Code Style Guidelines

### Imports
- Group by: PHP core → Vendor → App (alphabetically within each group)
- One use statement per line, no trailing backslash
- Always import the class, never rely on global namespace

### Formatting
- **Laravel Pint** with `laravel` preset (PSR-12 + Laravel conventions)
- Indent: 4 spaces (`.editorconfig` enforces this)
- Line endings: LF
- Final newline required; no trailing whitespace

### Types & Naming
- **PHP 8 attributes** for model metadata: `#[Fillable([...])]`, `#[Hidden([...])]` (NOT `$fillable`/`$hidden` properties)
- **Livewire attributes:** `#[Title]`, `#[Locked]`, `#[Validate]`, `#[Computed]`
- Return type hints on ALL methods (`: void`, `: View`, `: RedirectResponse`, `: BelongsTo`, etc.)
- Property types on ALL class properties (`public string $name = '';`)
- Controllers always extend `App\Http\Controllers\Controller`
- Models always use `HasFactory` trait with `/** @use HasFactory<UserFactory> */` docblock
- Relationship methods use type hints: `public function department(): BelongsTo`
- Eloquent queries: ALWAYS use `Model::query()->where(...)` (never `Model::where(...)`)
- Views use `compact()`: `return view('admin.dashboard', compact('stats', 'recentComplaints'));`
- Routes: `fn () => ...` short arrow closures; `->group(function (): void { ... })` with explicit void return
- Test names: descriptive snake_case strings inside `test()` / `describe()`

### Error Handling
- Controllers: `$request->validate([...])` inline validation
- Catch `ValidationException` in Livewire components to reset form state before re-throwing
- Activity logging on state transitions: create `ActivityLog` record with `old_status`, `new_status`, `note`
- Gates for authorization: `Gate::authorize('view', $complaint)`
- Middleware for role checks: `->middleware(['auth', 'role:admin'])`
- Abort 403 on unauthorized access in middleware (`abort(403)`)

### Livewire Conventions
- Full-page components via `Route::livewire()` (see `routes/settings.php`)
- Form actions dispatch browser events: `$this->dispatch('profile-updated', name: $user->name)`
- Validation rules from shared traits: `use PasswordValidationRules; $this->validate($this->passwordRules());`
- Dependency injection in `mount()` and action methods
- `#[Locked]` for read-only properties (set in `mount()`, never changed by frontend)
- `#[Validate('...', onUpdate: false)]` to suppress live validation

### Controllers
- Role-specific namespaces: `Admin`, `Staff`, `Student`
- Route-model binding with implicit `Complaint $complaint` parameter
- `$request->query('filter')` for filtering/index pages
- `with()` eager loading on paginated results
- `->withQueryString()` on paginators to preserve filters
- `back()->with('success', '...')` for redirect responses after mutations

### Migrations
- Anonymous classes: `return new class extends Migration { ... };`
- `Schema` facade with explicit `Blueprint $table` type hints
- `up()` and `down()` methods with return type `: void`

### Important Gotchas
- **Flux credentials required** for `composer install` (in CI: `composer config http-basic.composer.fluxui.dev "$FLUX_USERNAME" "$FLUX_LICENSE_KEY"`)
- Tests require `.env` file with `APP_KEY` set — CI copies `.env.example` and generates key
- Frontend assets must be built before tests pass (UI smoke tests depend on Vite manifest)
- `skipUnlessFortifyFeature()` helper from `Tests\TestCase` for Fortify feature-gated tests
- `TwoFactorAuthenticatable` trait on `User` model for 2FA support
- Do NOT modify `RoleMiddleware`, Fortify config, or auth scaffolding without approval
- `composer run dev` uses `concurrently` — requires Node dependencies installed
