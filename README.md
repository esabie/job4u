# Job4U

Job4U is a job board platform that connects employers with job seekers. Employers can post and manage roles; candidates can search, save jobs, apply with a CV, and track application progress.

**Tagline:** Where Opportunity Meets Talent

## Features

### Public
- Landing page and job search (`/jobs`)
- Filters for location, category, employment type, work arrangement, salary, and sort order
- Job detail pages with company logo, salary, and work arrangement
- Apply flow with CV upload (or saved profile CV) and optional employer questions

### Job seekers (candidates)
- Dashboard with application stats and applications-by-day chart
- Application history and status tracking
- Saved jobs
- Job alerts with email notifications
- Profile with phone, location, headline, summary, and reusable CV
- Notification preferences in Settings

### Employers
- Dashboard with active listings, new applicants, and applicants-by-day chart
- Create / edit / hide job posts
- Optional company logo upload
- Work arrangement (Onsite / Hybrid / Remote)
- Custom application questions (text, textarea, yes/no)
- Review applications and update status (Applied → Shortlisted → Interview → Rejected / Hired)
- Company name autocomplete suggestions

### Admins
- Moderate jobs (verify, activate, hide)
- Manage users (suspend / restore)
- Create an admin with `php artisan app:create-admin`

## Tech stack

| Layer | Technology |
| --- | --- |
| Backend | PHP 8.2+, Laravel 12 |
| Auth | Laravel Breeze (Blade) |
| Frontend | Blade, Tailwind CSS, Alpine.js, Vite |
| Editor | Quill (rich job descriptions) |
| Database | SQLite by default (MySQL/Postgres supported) |
| Queues | Database driver |
| Tests | PHPUnit |

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+ and npm
- SQLite (local default) or MySQL/PostgreSQL

## Local setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Database (SQLite default)
touch database/database.sqlite
php artisan migrate

# 4. Storage link (for logos and CVs)
php artisan storage:link

# 5. Frontend
npm install
npm run build

# 6. Run the app
php artisan serve
```

Optional all-in-one for day-to-day development (server + queue + logs + Vite):

```bash
composer run dev
```

Then open `http://127.0.0.1:8000` (or the port shown in the terminal).

### Create an admin user

```bash
php artisan app:create-admin admin@example.com --name="Admin Name"
```

### Useful artisan commands

```bash
php artisan migrate          # Run pending migrations
php artisan queue:work        # Process queued notifications/jobs
php artisan test             # Run the test suite
php artisan storage:link     # Public disk symlink
```

## Environment notes

Key values in `.env` / `.env.example`:

| Variable | Purpose |
| --- | --- |
| `APP_NAME` | Shown as Job4U in the UI / emails |
| `DB_CONNECTION` | `sqlite` locally; use `mysql` / `pgsql` in production |
| `SESSION_DRIVER` | Must be `database` or `redis` — never `cookie` (causes HTTP 431) |
| `SESSION_LIFETIME` | Idle session lifetime in minutes (default in example: `120`; keep ≥ 10 for OTP login) |
| `QUEUE_CONNECTION` | `database` — run a queue worker for notifications |
| `MAIL_MAILER` | `log` locally; use `resend` in production |
| `RESEND_API_KEY` | Resend API key (required when `MAIL_MAILER=resend`) |
| `MAIL_FROM_ADDRESS` | Must be a domain verified in Resend |
| `ALLOW_DESTRUCTIVE_DB_COMMANDS` | Must stay `false` unless you explicitly approve a destructive DB command |

### Email (Resend)

Password reset and app notifications use Laravel mail. To send via Resend:

1. Create an API key at [resend.com](https://resend.com)
2. Verify your sending domain in Resend
3. Set in `.env`:

```env
MAIL_MAILER=resend
RESEND_API_KEY=re_xxxxxxxxx
MAIL_FROM_ADDRESS=noreply@your-verified-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

4. Run `php artisan config:clear` (or `config:cache` in production)

Keep `MAIL_MAILER=log` locally if you do not want to send real email during development.

### Uploads

- **CVs:** PDF, DOC, DOCX — max **2 MB**
- **Company logos:** JPEG, JPG, PNG — max **2 MB**

### Database safety

Destructive Artisan DB commands (`migrate:fresh`, `migrate:refresh`, `db:wipe`, etc.) are blocked by default. Only run them if you have explicitly approved that action and temporarily set `ALLOW_DESTRUCTIVE_DB_COMMANDS=true`.

## Roles

| Role | Access |
| --- | --- |
| `candidate` | Search, apply, alerts, saved jobs, candidate dashboard |
| `employer` | Post jobs, review applications, employer dashboard |
| `admin` | Platform moderation at `/admin` |

Registration allows **Job Seeker** or **Employer**. Name and email are fixed after signup (editable elsewhere only by design choices in Profile).

## Project structure (high level)

```text
app/
  Enums/                 # ApplicationStatus, WorkArrangement, QuestionType
  Http/Controllers/      # Public, Candidate, Employer, Admin, Auth
  Models/                # User, Job, Application, JobAlert, JobQuestion, …
  Notifications/         # Application status, job alerts, new applications
  Support/               # Logging helpers, HTML sanitizer
resources/
  views/                 # Blade templates (public, candidate, employer, auth)
  js/                    # Alpine helpers, rich text, loading UI
  css/                   # Tailwind entry
routes/
  web.php                # App routes
  auth.php               # Breeze auth routes
database/migrations/     # Schema
tests/                   # Feature and unit tests
```

## Testing

```bash
php artisan test
```

Or:

```bash
composer test
```

## Production checklist

- Switch to MySQL or PostgreSQL (avoid SQLite for concurrent production traffic)
- Set `APP_ENV=production`, `APP_DEBUG=false`, and a strong `APP_KEY`
- Configure Resend mail (`MAIL_MAILER=resend`, `RESEND_API_KEY`, verified `MAIL_FROM_ADDRESS`) for password reset and notifications
- Run `php artisan queue:work` under Supervisor (or similar)
- Build assets with `npm run build`
- Serve behind Nginx/Apache with HTTPS
- Keep `ALLOW_DESTRUCTIVE_DB_COMMANDS=false`

## License

This application is built on the [Laravel framework](https://laravel.com), which is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
