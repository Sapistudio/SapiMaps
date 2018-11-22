Installation
------------

Issue following command in console:

```php
composer require sapistudio/sapimaps
```

Usage
------------

Here is an example of making request search:
```php
use Sapistudio\SapiMaps\Handler;
$response = Handler::load('nearbysearch')->setConfig("key","your_key")->setParam->(['location'=>latlng,'type'=>'gas_station'])->get());
```
