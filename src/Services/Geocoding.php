<?php 
namespace SapiStudio\SapiMaps\Services;

use SapiStudio\SapiMaps\Service as MapsService;

class Geocoding extends MapsService
{
    /**
     * Geocoding::getFormattedAddress()
     * 
     * @return
     */
    public function getFormattedAddress(){
        return $this->get('formatted_address');
    }
    
    /**
     * Geocoding::getLocation()
     * 
     * @return
     */
    public function getLocation(){
        return implode(',',$this->get('geometry.location'));
    }
    
    /**
     * Geocoding::formatResponse()
     * 
     * @param mixed $response
     * @return
     */
    protected function formatResponse($response){
        return $response[0];
    }
}