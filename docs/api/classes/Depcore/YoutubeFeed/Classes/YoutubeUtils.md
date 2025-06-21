***

# YoutubeUtils

Utility class for handling YouTube-related operations within the plugin.

This class provides static methods and helpers for interacting with the YouTube API,
processing YouTube data, and supporting YouTube feed functionality.

* Full name: `\Depcore\YoutubeFeed\Classes\YoutubeUtils`




## Methods


### getChannelApiCallFromUrl

Extracts the YouTube channel API call information from a given YouTube channel URL.

```php
public static getChannelApiCallFromUrl(string $url): array|null
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | **string** | The URL of the YouTube channel. |


**Return Value:**

Returns an array containing API call parameters if extraction is successful, or null on failure.




***

### getChannelIDFromLink

Extracts the YouTube channel ID from a given YouTube channel URL.

```php
public static getChannelIDFromLink(\Madcoda\Youtube\Youtube $youtube, string $url): string|null
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$youtube` | **\Madcoda\Youtube\Youtube** | An instance of the Youtube API client or utility class. |
| `$url` | **string** | The URL of the YouTube channel. |


**Return Value:**

The extracted channel ID if found, or null on failure.




***

### getUploadPlaylistId

Retrieves the upload playlist ID for a given YouTube channel.

```php
public static getUploadPlaylistId(\Madcoda\Youtube\Youtube $youtube, string $channelId): string|null
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$youtube` | **\Madcoda\Youtube\Youtube** | An instance of the Youtube API client. |
| `$channelId` | **string** | The ID of the YouTube channel. |


**Return Value:**

The upload playlist ID if found, or null on failure.




***


***
> Automatically generated on 2025-06-21
