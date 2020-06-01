<?php 
namespace SapiStudio\SapiMaps;
use \SapiStudio\RestApi\AbstractHttpClient;

class Handler extends AbstractHttpClient
{
    protected $apiKey;
    
    public static function __callStatic($name,$arguments)
    {
        $class = __NAMESPACE__.'\Providers\\'.$name;
        if (!class_exists($class))
            throw new Exception('Could not find '.$name.' maps provider');
        return new $class(...$arguments);
    }
    
    public function __construct($apiKey = null)
    {
        parent::__construct();
        $this->apiKey = $apiKey;
    }
    
    
}