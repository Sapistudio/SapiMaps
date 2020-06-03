<?php 
namespace SapiStudio\SapiMaps\Providers;
use \SapiStudio\SapiMaps\Handler;
use \SapiStudio\SapiMaps\Services\Address;

class Here extends Handler
{
    const BASE_URL              = "https://[service].search.hereapi.com";
    const MAP_URL               = 'https://image.maps.ls.hereapi.com/mia/1.6';
    protected static $endpoints = ['discover','autosuggest','geocode','revgeocode','browse','lookup'];
    protected $currentEndpoint  = null;
    protected $responseFormat   = 'json';
    protected static $mapParams = ['lc' => '3b5998','lw' => '6','t' => '6','w' => '800','h' => '640'];
    protected $mapSchemeType    = [
        'normal.day','satellite.day','terrain.day','hybrid.day','normal.day.transit','normal.day.grey','normal.day.mobile','normal.night.mobile','terrain.day.mobile','hybrid.day.mobile','normal.day.transit.mobile','normal.day.grey.mobile','pedestrian.day','pedestrian.night'
    ];
    
    /** Here::__construct()*/
    public function __construct( $apiKey = null)
    {
        parent::__construct($apiKey);
    }
    
    /** Here::setParams()*/
    public function setParams($params = []){
        self::$mapParams = array_merge_recursive(self::$mapParams,$params);
        return $this;
    }
    
    /** Here::getParams()*/
    public function getParams(){
        return self::$mapParams;
    }
    
    /** Here::revGeocode() */
    public function revGeocode($coordinates){
        $coordinates = (is_array($coordinates)) ? implode(',',$coordinates) : $coordinates;
        $this->currentEndpoint = 'revgeocode';
        return Address::load($this->get('revgeocode',['at' => $coordinates]));
    }
    
    /** Here::mapRoute() */
    public function mapRoute($wayPoints = []){
        $params = $this->getParams();
        foreach($wayPoints as $wayPointIndex => $wayPointValue){
            $params['waypoint'.$wayPointIndex] = (is_array($wayPointValue)) ? implode(',',$wayPointValue) : $wayPointValue;
        }
        return $this->getRequestUri(self::MAP_URL.'/routing',$params);
    }
    
    /** Here::mapView()*/
    public function mapView($coordinates = []){
        $params         = $this->getParams();
        $params['c']    = implode(',',$coordinates);
        $params['z']    = 16;
        return $this->getRequestUri(self::MAP_URL.'/mapview',$params);
    }

    /**  Here::buildRequestUri()*/
    protected function buildRequestUri($baseUri,$path = false)
    {
        $this->addQuery('apiKey',$this->apiKey);
        $url    = (substr($path, 0, 4) === 'http') ? $path : rtrim(str_replace('[service]',$this->currentEndpoint,self::BASE_URL),'/').'/v1/'.$this->currentEndpoint;
        return $url;
    }
    
    /** Here::validateApiResponse() */
    protected function validateApiResponse($response = null){
        $response = json_decode(json_encode($response),true);
        if($response['error']){
            $error = ($response['error_description']) ? $response['error_description'] : $response['error']['description'];
            throw new \Exception('Invalid response: '.$error);
        }elseif($response['status'] == 400){
            throw new \Exception($response['title'].' '.$response['cause']);
        }
        $this->flushQuery();
        return $response;
    }
}
