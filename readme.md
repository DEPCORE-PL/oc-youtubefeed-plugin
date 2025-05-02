# YouTube Feed Plugin for OctoberCMS

Display a dynamic YouTube playlist feed with pagination. Shows an unstyled video list and a "View More" button to load additional items.

---

## Features
- Display YouTube playlist videos
- "View More" button for pagination
- Convert channel URLs to uploads playlist ID via settings tool
- Customizable items per page

---

## Installation
1. Clone into `plugins/depcore/youtubefeed`
2. Run migrations:
   ```bash
   php artisan october:up
   ```
3. Configure your YouTube API key in **Settings → YouTube Feed**

---

## Configuration

### Plugin Settings (Backend)
1. **API Key**: YouTube Data API v3 key (required)
2. **Tools Tab**: Enter a YouTube channel URL to get its uploads playlist ID

### Component Properties
Add the component to any page/layout and configure:

| Property       | Description                                                                 |
|----------------|-----------------------------------------------------------------------------|
| `feedPlaylist` | YouTube playlist ID (e.g., `UUH7xZRbt0N_ChUvud2Vr2sA` for uploads playlist) |
| `perPage`      | Number of videos to load per page (default: 5)                              |

---

## Usage

### 1. Template Implementation
Add the component to your template **without** wrapping divs (it handles its own markup):
```twig
{% component 'youtubeFeed' feedPlaylist="UUH7xZRbt0N_ChUvud2Vr2sA" perPage=5 %}
```

---

## Playlist ID Tool

1. Go to **Settings → YouTube Feed → Tools**
2. Enter a channel URL (e.g., `https://www.youtube.com/@LofiGirl`)
3. Click "Get uploads playlist" to automatically retrieve the uploads playlist ID

---

## Troubleshooting

**Feed Not Showing?**
- Verify YouTube API key is valid and has quota
- Ensure playlist ID matches format `UU[...]` (uploads playlist)
- Check browser console for API errors

**Playlist ID Tool Fails?**
- Use full channel URLs (e.g., with `@` handle or `/channel/` path)
- Channel must have public videos

---

## Development

### Component Parameters
Configure in CMS page/components settings:
```yaml
feedPlaylist: UUH7xZRbt0N_ChUvud2Vr2sA
perPage: 5
```
