# Candidtech Interiors

This repository contains a Laravel application for the Candidtech Interiors homepage and admin CRUD panel.

## What is included

- Dynamic homepage built from the original HTML/CSS/JS project content
- Admin panel for managing:
  - Banner
  - Services
  - About section
  - Why choose us features
  - Recent projects
  - Testimonials
  - FAQ
  - Company contact details
  - Contact messages
- Admin login using Laravel authentication and the `users` table
- Seeded demo data matching the original static website

## Default admin login

- Email: `admin@gmail.com`
- Password: `12345678`

## Setup

1. Copy `.env.example` to `.env`
2. Set your database connection in `.env`
3. Install PHP dependencies:
   ```bash
   composer install
   ```
4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```
6. Create the storage symlink for public file uploads:
   ```bash
   php artisan storage:link
   ```
7. Start the development server:
   ```bash
   php artisan serve
   ```

Open the website at `http://127.0.0.1:8000`.

## Admin panel

Visit `http://127.0.0.1:8000/admin/login` and sign in with the default admin credentials.

### File uploads

The admin panel supports direct file uploads for:
- Banner background images
- Service icons
- Feature icons
- Project images
- Testimonial avatars
- About section images

Uploaded files are stored in `storage/app/public/uploads/` and are accessible via `/storage/uploads/filename`.

## Seed data

The database seeder creates:

- Admin user
- Homepage banner
- About section
- Services
- Features
- Recent projects
- Testimonials
- FAQ entries
- Company contact details
- Sample contact message

## GitHub deployment

This project is ready to publish to GitHub. To push it:

```bash
git remote set-url origin https://github.com/<your-username>/<repo-name>.git
git add .
git commit -m "Initial Candidtech Interiors Laravel project"
git push -u origin main
```

## Notes

- Ensure MySQL is running and `.env` contains correct DB settings.
- Do not commit `.env` to GitHub.
- Run `php artisan migrate --seed` to populate the demo website data.
