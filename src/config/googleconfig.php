<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    */
    'key'       => 'YOUR_API_KEY',
    /*
    |--------------------------------------------------------------------------
    | Verify SSL Peer
    |--------------------------------------------------------------------------
     */
    'ssl_verify_peer' => FALSE,
    /*
    |--------------------------------------------------------------------------
    | Service URL
    |--------------------------------------------------------------------------
    | url - web service URL
    | type - request type POST or GET
    | key - API key, if different to API key above
    | endpoint - boolean, indicates whenever output parameter to be used in the request or not
    | param - accepted request parameters
    |--------------------------------------------------------------------------
    */
    'service' => [
        'geocoding' => [
            'url'                   => 'https://maps.googleapis.com/maps/api/geocode/',
            'type'                  => 'GET',
            'endpoint'              =>  true,
            'responseDefaultKey'    => 'results',
            'param'                 => [
                'address'       => null,
                'bounds'        => null,
                'key'           => null,
                'region'        => null,
                'language'      => null,
                'result_type'   => null,
                'location_type' => null,
                'latlng'        => null,
                'place_id'      => null
            ]
        ],
        'directions' => [
            'url'                   => 'https://maps.googleapis.com/maps/api/directions/',
            'type'                  => 'GET',
            'endpoint'              =>  true,
            'responseDefaultKey'    =>  'routes',
            'param'                 => [
                'origin'                        => null, // required
                'destination'                   => null, //required
                'mode'                          => null,
                'waypoints'                     => null,
                'place_id'                      => null,
                'alternatives'                  => null,
                'avoid'                         => null,
                'language'                      => null,
                'units'                         => null,
                'region'                        => null,
                'departure_time'                => null,
                'arrival_time'                  => null,
                'transit_mode'                  => null,
                'transit_routing_preference'    => null
            ]
        ],
        'distance' => [
            'url'                   => 'https://maps.googleapis.com/maps/api/distancematrix/',
            'type'                  => 'GET',
            'endpoint'              =>  true,
            'responseDefaultKey'    => 'rows',
            'param'                 => [
                'origins'                       => null,
                'destinations'                  => null,
                'key'                           => null,
                'mode'                          => null,
                'language'                      => null,
                'avoid'                         => null,
                'units'                         => null,
                'departure_time'                => null,
                'arrival_time'                  => null,
                'transit_mode'                  => null,
                'transit_routing_preference'    => null
            ]
        ],
        'snapToRoads' => [
            'url'                   => 'https://roads.googleapis.com/v1/snapToRoads?',
            'type'                  => 'GET',
            'endpoint'              =>  false,
            'responseDefaultKey'    => 'snappedPoints',
            'param'                 => [
                'locations'             => null,
                'path'                  => null,
                'samples'               => null,
                'key'                   => null,
            ]
        ],
        'speedLimits' => [
            'url'                   => 'https://roads.googleapis.com/v1/speedLimits?',
            'type'                  => 'GET',
            'endpoint'              =>  false,
            'responseDefaultKey'    => 'speedLimits',
            'param'                 => [
                'path'                  => null,
                'placeId'               => null,
                'units'                 => null,
                'key'                   => null,
            ]
        ],
        'nearbysearch' => [
            'url'                   => 'https://maps.googleapis.com/maps/api/place/nearbysearch/',
            'type'                  => 'GET',
            'endpoint'              =>  true,
            'responseDefaultKey'    => 'results',
            'param'                 => [
                'key'           => null,  
                'location'      => null,
                'radius'        => 500,
                'keyword'       => null,
                'language'      => null,
                'minprice'      => null,
                'maxprice'      => null,
                'name'          => null,
                'opennow'       => null,
                'rankby'        => null,
                'type'          => null,
                'pagetoken'     => null,
                'zagatselected' => null,
            ]           
        ],
        'textsearch' => [
            'url'                   => 'https://maps.googleapis.com/maps/api/place/textsearch/',
            'type'                  => 'GET',
            'endpoint'              =>  true,
            'responseDefaultKey'    => 'results',
            'param'                 => [
                'key'           => null,  
                'query'         => null,
                'location'      => null,
                'radius'        => null,
                'language'      => null,
                'minprice'      => null,
                'maxprice'      => null,
                'opennow'       => null,
                'type'          => null,
                'pagetoken'     => null,
                'zagatselected' => null,
            ]           
        ],
        'placedetails' => [
            'url'                   => 'https://maps.googleapis.com/maps/api/place/details/',
            'type'                  => 'GET',
            'endpoint'              =>  true,                                
            'responseDefaultKey'    => 'result',
            'param'                 => [
                'key'           => null,  
                'placeid'       => null,
                'extensions'    => null,
                'language'      => null,
            ]           
        ],
        'placephoto' => [
            'url'                   => 'https://maps.googleapis.com/maps/api/place/photo?',
            'type'                  => 'GET',
            'endpoint'              =>  false,                                
            'responseDefaultKey'    => 'image',
            'param'                 => [
                'key'           => null,
                'photoreference'=> null,
                'maxheight'     => null,
                'maxwidth'      => null,
            ]           
        ]
    ]
];