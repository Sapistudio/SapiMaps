<?php namespace SapiStudio\SapiMaps;

use Illuminate\Support\Arr;
use SapiStudio\Http\Browser\CurlClient;
use SapiStudio\Http\Url as UrlHandler;

class Handler
{
    protected $endpoint;
    protected $service;
    protected $key;
    protected $requestUrl;
    protected $verifySSL;
    private $configData     = [];
    private $serviceData    = [];
    protected $responseBody = [];
    protected static $responseKey = 'responseDefaultKey';
    
     /**  No errors occurred, the address was successfully */
    const STATUS_SUCCESS = "OK";
    
  
    /**
     * Handler::load()
     * 
     * @return
     */
    public static function load($service = null)
    {
        return new self($service);
    }

    /**
     * Handler::__construct()
     * 
     * @return
     */
    public function __construct($service = null)
    {
        $this->service = strtolower($service);
        $this->build();
    }

    /**
     * Handler::getConfig()
     * 
     * @return
     */
    public function getConfig($key, $default = '')
    {
        return Arr::get($this->configData, $key, $default);
    }

    /**
     * Handler::getBody()
     * 
     * @return
     */
    public function getBody(){
        return $this->responseBody;
    }
    
    /**
     * Handler::getKey()
     * 
     * @return
     */
    public function getKey(){
        return $this->key;
    }
  
    /**
     * Handler::setConfig()
     * 
     * @return
     */
    public function setConfig($key, $value)
    {
        $keys = is_array($key) ? $key : [$key => $value];
        foreach ($keys as $key => $value) {
            Arr::set($this->configData, $key, $value);
        }
        return $this;
    }

    /**
     * Handler::getService()
     * 
     * @return
     */
    public function getService($key, $default = '')
    {
        return Arr::get($this->serviceData, $key, $default);
    }

    /**
     * Handler::setService()
     * 
     * @return
     */
    public function setService()
    {
        $serviceData = $this->getConfig('service.' . $this->service);
        foreach ($serviceData as $key => $value) {
            Arr::set($this->serviceData, $key, $value);
        }
        Arr::forget($this->configData,'service');
        return $this;
    }

    /**
     * Handler::setParam()
     * 
     * @return
     */
    public function setParam($key = null, $value = null)
    {
        if(is_array($key))
            Arr::set($this->serviceData, 'param', array_merge($this->getService('param'),$key));
        else{
            if (Arr::has($this->serviceData, 'param.' . $key))
                Arr::set($this->serviceData, 'param.' . $key, $value);
        }
        return $this;
    }

    /**
     * Handler::getParam()
     * 
     * @return
     */
    public function getParam($key = null)
    {
        if(is_null($key))
            return $this->getService('param');
        return (Arr::has($this->serviceData,'param.'.$key)) ? $this->getService('param.' . $key) : null;
    }

    /**
     * Handler::setEndpoint()
     * 
     * @return
     */
    public function setEndpoint($key = 'json')
    {
        $endPoints      = ['xml','json'];
        $this->endpoint = (in_array($key,$endPoints)) ? $key : 'json';
        return $this;
    }

    /**
     * Handler::getEndpoint()
     * 
     * @return
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Handler::get()
     * 
     * @return
     */
    public function get()
    {
        return $this->makeRequest();
    }

    /**
     * Handler::build()
     * 
     * @return
     */
    protected function build()
    {
        // Check for config file
        $configFile = __dir__ . DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'googleconfig.php';
        if (!file_exists($configFile))
            throw new \ErrorException('Unable to find config file.');
        $this->configData = require $configFile;
        // Validate Key parameter
        if (!Arr::has($this->configData,'key'))
            throw new \ErrorException('Unable to find Key parameter in configuration file.');
        // Validate service config
        if (!Arr::has($this->configData, 'service.' . $this->service))
            throw new \ErrorException('Unable to find '.$this->service.' parameter in configuration file.');
        $this->setService();
        // set default endpoint
        $this->setEndpoint();
        // is service key set, use it, otherwise use default key
        $this->key = (!$this->getService('key')) ? $this->getConfig('key') : $this->getService('key');
        // set service url
        $this->requestUrl = UrlHandler::parse($this->getService('url'));
        // is ssl_verify_peer key set, use it, otherwise use default key
        $this->verifySSL = (bool)$this->getConfig('ssl_verify_peer');
    }

    /**
     * Handler::makeRequest()
     * 
     * @return
     */
    protected function makeRequest()
    {
        $requestType = trim(strtolower($this->getService('type')));
        if($this->getService('endpoint'))
            $this->requestUrl->appendPathSegment($this->getEndpoint());
        if($requestType != 'post' && $this->getParam())
            $this->requestUrl->setQueryFromArray($this->getParam());
        $this->requestUrl->setQueryParameter('key',$this->key);
        switch ($requestType){
            case 'POST':
                $postData = json_encode($this->getParam());
                break;
            case 'GET':
            default:
                break;
        }
        $request        = CurlClient::make()->{$requestType}($this->requestUrl->write());
        $responseBody   = $this->unserializeResponse($request->getBody()->getContents());
        $responseStatus = $request->getStatusCode();
        switch($responseStatus){
            case 200:
                if($responseBody['status'] != self::STATUS_SUCCESS)
                    throw new \ErrorException($responseBody['status'].':'.$responseBody['error_message']);
                break;
            default:
                throw new \ErrorException($responseStatus.' '.$request->getReasonPhrase().':'.$responseBody['error_message']);
        }
        $checkClass = __NAMESPACE__."\Services\\".ucfirst($this->service);
        $this->responseBody = (Arr::has($responseBody,$this->getService(self::$responseKey))) ? Arr::get($responseBody,$this->getService(self::$responseKey)) : $responseBody;
        return (class_exists($checkClass)) ? new $checkClass($this) : $responseBody;
    }
    
    /**
     * Handler::unserializeResponse()
     * 
     * @return
     */
    protected function unserializeResponse($response = null){
        switch($this->getEndpoint()){
            case "json":
                return json_decode($response,true);
                break;
            case "xml":
                return (array) json_decode(json_encode(simplexml_load_string($response, null, LIBXML_NOCDATA)),true);
                break;
            default:
                throw new \ErrorException('Invalid response type');
                break;
        }
    }
}