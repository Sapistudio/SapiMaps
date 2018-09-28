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

$response = Handler::load('nearbysearch')->setApiKey('your_key')->setParam(['origin'=>'start','destination'=>'end'])->query();

```
