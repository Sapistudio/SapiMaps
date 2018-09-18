Installation
------------

Issue following command in console:

```php
composer require sapistudio/sapimaps
```

Usage
------------

Here is an example of making request to Geocoding API:
```php
use Sapistudio\SapiMaps\Handler;
$response = Handler::load('nearbysearch')->setConfig("key","your_key")->setParam->(['location'=>latlng,'type'=>'gas_station'])->get());
```

Available methods
------------

* [`load( $serviceName )`](#load)
* [`setEndpoint( $endpoint )`](#setEndpoint)
* [`getEndpoint()`](#getEndpoint)
* [`setParamByKey( $key, $value)`](#setParamByKey)
* [`setParam( $parameters)`](#setParam)
* [`get()`](#get)
* [`get( $key )`](#get)
* [`containsLocation( $lat, $lng )`](#containsLocation)
* [`isLocationOnEdge( $lat, $lng, $tolrance)`](#isLocationOnEdge)

---

<a name="load"></a>
**`load( $serviceName )`** - load web service by name 

Accepts string as parameter, web service name as specified in configuration file.  
Returns reference to it's self.

```php

\GoogleMaps::load('geocoding') 
... 

```
---

<a name="setEndpoint"></a>
**`setEndpoint( $endpoint )`** - set request output

Accepts string as parameter, `json` or `xml`, if omitted defaulted to `json`.  
Returns reference to it's self.

```php
$response = \GoogleMaps::load('geocoding')
		->setEndpoint('json')  // return $this
		...
```

---

<a name="getEndpoint"></a>
**`getEndpoint()`** - get current request output

Returns string.

```php
$endpoint = \GoogleMaps::load('geocoding')
		->setEndpoint('json')
		->getEndpoint();

echo $endpoint; // output 'json'
```

---

<a name="setParamByKey"></a>
**`setParamByKey( $key, $value )`** - set request parameter using key:value pair

Accepts two parameters:
* `key` - body parameter name
* `value` - body parameter value 

Deeply nested array can use 'dot' notation to assign value.  
Returns reference to it's self.

```php
$endpoint = \GoogleMaps::load('geocoding')
   ->setParamByKey('address', 'santa cruz')
   ->setParamByKey('components.administrative_area', 'TX') //return $this
    ...
```

---

<a name="setParam"></a>
**`setParam( $parameters)`** - set all request parameters at once

Accepts array of parameters  
Returns reference to it's self.

```php
$response = \GoogleMaps::load('geocoding')
                ->setParam([
                   'address'     => 'santa cruz',
                   'components'  => [
                        'administrative_area'   => 'TX',
                        'country'               => 'US',
                         ]
                     ]) // return $this
...
```

---

<a name="get"></a>
* **`get()`** - perform web service request (irrespectively to request type POST or GET )
* **`get( $key )`** - accepts string response body key, use 'dot' notation for deeply nested array

Returns web service response in the format specified by **`setEndpoint()`** method, if omitted defaulted to `JSON`. 
Use `json_decode()` to convert JSON string into PHP variable. See [Processing Response](https://developers.google.com/maps/documentation/webservices/#Parsing) for more details on parsing returning output.

```php
$response = \GoogleMaps::load('geocoding')
                ->setParamByKey('address', 'santa cruz')
                ->setParamByKey('components.administrative_area', 'TX') 
                 ->get();

var_dump( json_decode( $response ) );  // output 

/*
{\n
   "results" : [\n
      {\n
         "address_components" : [\n
            {\n
               "long_name" : "277",\n
               "short_name" : "277",\n
               "types" : [ "street_number" ]\n
            },\n
            ...
*/


```

Example with `$key` parameter

```php
$response = \GoogleMaps::load('geocoding')
                ->setParamByKey('latlng', '40.714224,-73.961452') 
                 ->get('results.formatted_address');

var_dump( json_decode( $response ) );  // output 

/*
array:1 [▼
  "results" => array:9 [▼
    0 => array:1 [▼
      "formatted_address" => "277 Bedford Ave, Brooklyn, NY 11211, USA"
    ]
    1 => array:1 [▼
      "formatted_address" => "Grand St/Bedford Av, Brooklyn, NY 11211, USA"
    ]
            ...
*/


```

---

<a name="isLocationOnEdge"></a>
**`isLocationOnEdge( $lat, $lng, $tolrance = 0.1 )`** - To determine whether a point falls on or near a polyline, or on or near the edge of a polygon, pass the point, the polyline/polygon, and optionally a tolerance value in degrees.

This method only available with Google Maps Directions API.

Accepted parameter:
* `$lat` - double latitude 
* `$lng` - double longitude 
* `$tolrance` - double

```php
$response = \GoogleMaps::load('directions')
            ->setParam([
                'origin'          => 'place_id:ChIJ685WIFYViEgRHlHvBbiD5nE', 
                'destination'     => 'place_id:ChIJA01I-8YVhkgRGJb0fW4UX7Y', 
            ])
           ->isLocationOnEdge(55.86483,-4.25161);

    dd( $response  );  // true
```

---


<a name="containsLocation"></a>
**`containsLocation( $lat, $lng )`** -To find whether a given point falls within a polygon.

This method only available with Google Maps Directions API.

Accepted parameter:
* `$lat` - double latitude 
* `$lng` - double longitude 

```php
$response = \GoogleMaps::load('directions')
            ->setParam([
                'origin'          => 'place_id:ChIJ685WIFYViEgRHlHvBbiD5nE', 
                'destination'     => 'place_id:ChIJA01I-8YVhkgRGJb0fW4UX7Y', 
            ])
           ->containsLocation(55.86483,-4.25161);

    dd( $response  );  // true
```

