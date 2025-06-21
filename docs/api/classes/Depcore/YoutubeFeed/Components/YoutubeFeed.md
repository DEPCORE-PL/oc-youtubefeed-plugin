***

# YoutubeFeed

YoutubeFeed component for the Youtube Feed plugin.

This is the main frontend component responsible for displaying a dynamic YouTube playlist feed
with pagination support in OctoberCMS. It loads videos from a specified YouTube playlist (typically
an uploads playlist) and provides a "View More" button to fetch additional items via AJAX.

Features:
- Fetches and displays videos from a YouTube playlist using the YouTube Data API v3.
- Supports configurable number of items per page.
- Handles AJAX-based pagination for seamless loading of more videos.
- Integrates with plugin settings for API key management.

Component Properties:

* Full name: `\Depcore\YoutubeFeed\Components\YoutubeFeed`
* Parent class: [`ComponentBase`](../../../Cms/Classes/ComponentBase.md)

**See Also:**

* https://github.com/madcoda/php-youtube-api - for YouTube API integration
* \Depcore\YoutubeFeed\Components\Depcore\YoutubeFeed\Models\YoutubeSettings - for API key configuration



## Properties


### items



```php
public $items
```






***

### nextPage



```php
public $nextPage
```






***

### playlist



```php
public $playlist
```






***

### youtube



```php
private \Madcoda\Youtube\Youtube $youtube
```






***

## Methods


### componentDetails

Returns details about the component, such as its name and description.

```php
public componentDetails(): array
```









**Return Value:**

An associative array containing the component's name and description.




***

### defineProperties

Defines the properties available for the YoutubeFeed component.

```php
public defineProperties(): array
```

This method should return an array of property definitions that can be configured
in the backend for this component. Each property can include options such as
title, description, type, default value, and validation rules.







**Return Value:**

The array of property definitions for the component.




***

### onRun

Handles the component's execution when the page is run.

```php
public onRun(): void
```

This method is automatically called by the OctoberCMS framework
when the component is initialized during the page lifecycle.

Use this method to prepare variables, fetch data, or perform
any setup required before rendering the component's output.










***

### onRender

Handles the rendering process for the YoutubeFeed component.

```php
public onRender(): void
```

This method is triggered when the component needs to be rendered.
It can be used to prepare data, set variables, or perform any logic
required before displaying the component's output.










***

### onLoadMore

Handles the AJAX request to load more YouTube feed items.

```php
public onLoadMore(): mixed
```

This method is typically triggered when the user requests additional content,
such as clicking a "Load More" button. It processes the request, retrieves
the next set of YouTube feed items, and returns them for rendering.







**Return Value:**

The response containing additional YouTube feed items.




***

### loadItems

Loads items for the YouTube feed component.

```php
protected loadItems(): void
```

This method retrieves and processes YouTube feed items to be displayed
by the component. The specific implementation details depend on the
requirements of the component and the data source.










***


***
> Automatically generated on 2025-06-21
