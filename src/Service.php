<?php 
namespace SapiStudio\SapiMaps;

use Illuminate\Support\Arr;
use SapiStudio\SapiMaps\Handler as MapObject;
use SapiStudio\Http\Url as UrlHandler;

abstract class Service
{
    protected $responseData;
    protected $handler = null;
    
    /**
     * Service::__construct()
     * 
     * @param mixed $response
     * @return
     */
    public function __construct(MapObject $response)
    {
        $this->handler      = $response;
        $this->responseData = $this->formatResponse($response->getBody());
    }
    
    /**
     * Service::get()
     * 
     * @param mixed $key
     * @param string $default
     * @return
     */
    protected function get($key, $default = '')
    {
        return Arr::get($this->responseData,$key, $default);
    }
    
    /**
     * Service::formatResponse()
     * 
     * @param mixed $response
     * @return
     */
    abstract protected function formatResponse($response);
}