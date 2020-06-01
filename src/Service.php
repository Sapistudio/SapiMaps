<?php 
namespace SapiStudio\SapiMaps;

use Illuminate\Support\Arr;
use SapiStudio\SapiMaps\Handler as MapObject;

abstract class Service
{
    
    /** Service::get() */
    protected function get($key, $default = '')
    {
        return Arr::get($this->responseData,$key, $default);
    }
    
    /** Service::formatResponse()*/
    abstract protected function formatResponse();
}