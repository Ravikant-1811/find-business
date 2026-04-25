# Find Business

Find Business is a PHP + MySQL web platform for business discovery, listing submissions, and lead-style follow-up data collection.  
It includes directory pages, category/discovery views, business profile pages, and form-based user interactions.

## Core Features

- Business listing and discovery pages
- Category and discount browsing flows
- Business submission forms
- Contact and feedback pages
- Google Places related integrations
- API/AJAX endpoints for async operations

## Tech Stack

- PHP (procedural, multi-page architecture)
- MySQL / MariaDB
- HTML, CSS, JavaScript
- Apache or Nginx (local or production)

## Project Structure

- `index.php` - main landing/listing entry point
- `add_business.php` - business submission flow
- `place_details.php` - business detail screen
- `api/` - API handlers/endpoints
- `ajax/` - asynchronous request handlers
- `assets/` - CSS, UI assets, static files
- `database/` - SQL dump and schema-related files
- `photos/` - uploaded or listing images

## Local Setup

1. Clone the repository.
2. Create a MySQL database.
3. Import the SQL dump:
   ```bash
   mysql -u root -p your_database_name < database/u792021313_directory.sql
   ```
4. Update database credentials in `config.php`.
5. Start a local PHP server from project root:
   ```bash
   php -S localhost:8000
   ```
6. Open [http://localhost:8000](http://localhost:8000).

## Optional Table Bootstrap

If you want to create/update the `data_places` table structure used by Google place data:

```bash
php setup_database.php
```

## Configuration Notes

- `config.php` currently contains hardcoded DB credentials and an API key.
- Recommended improvement:
  - move secrets to environment variables
  - rotate exposed credentials/API keys before production deployment
  - keep production config outside version-controlled files

## Production Notes

- Enable HTTPS and secure headers.
- Validate and sanitize all form inputs server-side.
- Restrict direct access to debug/test files before deployment.
- Set correct file/folder permissions for `photos/` and session storage.

## License

Internal business project. Add your preferred license if distributing publicly.
