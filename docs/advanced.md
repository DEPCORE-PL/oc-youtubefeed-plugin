# Advanced Examples

## Using Multiple Feeds
You can add multiple instances of the component to a page with different playlists:
```twig
<h2>Channel 1</h2>
{% component 'youtubeFeed' feedPlaylist="UUH7xZRbt0N_ChUvud2Vr2sA" perPage=5 %}

<h2>Channel 2</h2>
{% component 'youtubeFeed' feedPlaylist="UU_xxxxyyyyzzzz" perPage=3 %}
```

## Styling the Output
The plugin outputs unstyled HTML. Use CSS to style the video list and buttons as desired. Example:
```css
.youtube-feed-list {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}
.youtube-feed-item {
  width: 300px;
}
```

## AJAX Pagination
The "View More" button uses AJAX to load additional videos without reloading the page. No extra setup is required.
