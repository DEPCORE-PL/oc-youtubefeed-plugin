# Installation

1. Clone the plugin into your OctoberCMS plugins directory:
   ```fish
   git clone <repo-url> plugins/depcore/youtubefeed
   ```
2. Run database migrations:
   ```fish
   php artisan october:up
   ```
3. Install dependencies (if not already):
   ```fish
   composer install
   ```
4. Configure your YouTube API key in **Settings → YouTube Feed** in the backend.
