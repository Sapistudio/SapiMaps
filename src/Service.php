<?php 
namespace SapiStudio\SapiMaps;

use Illuminate\Support\Arr;

abstract class Service
{
    protected $responseData;
    
    /**
     * Service::__construct()
     * 
     * @param mixed $response
     * @return
     */
    public function __construct($response = [])
    {
        $this->responseData = $this->formatResponse($response);
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