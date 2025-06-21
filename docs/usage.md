# Usage

## Basic Template Implementation
Add the component to your CMS page or layout:
```twig
{% component 'youtubeFeed' feedPlaylist="UUH7xZRbt0N_ChUvud2Vr2sA" perPage=5 %}
```
- The component handles its own markup, including the video list and the "View More" button.
- No need to wrap in extra divs unless you want to style the container.

## CMS Page Example
In your CMS page YAML front matter:
```yaml
components:
    youtubeFeed:
        feedPlaylist: UUH7xZRbt0N_ChUvud2Vr2sA
        perPage: 5
```
And in the page body:
```twig
{% component 'youtubeFeed' %}
```

## Customizing Items Per Page
Change the `perPage` property to show more or fewer videos per load:
```twig
{% component 'youtubeFeed' feedPlaylist="UUH7xZRbt0N_ChUvud2Vr2sA" perPage=10 %}
```
