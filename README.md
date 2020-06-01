Installation
------------

Issue following command in console:

```php
composer require sapistudio/sapimaps
```

Usage
------------

Initiate here provider
```php
use Sapistudio\SapiMaps\Handler;
$here = Handler::Here(Config::HERE_API_KEY());
```
Get a reverse geocode address
```php
$address =$here->revGeocode($coordinates);
// $coordinates can be an array of lat,lon , or passed as arguments
```
Get a static map image url with route draw
```php
$mapRoute =$here->mapRoute($coordinates);
// $coordinates must be an array of coordinates. ex: [[lat1,lon1],[lat2,lon2]..etc]
```
