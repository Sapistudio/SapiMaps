<?php 
namespace SapiStudio\SapiMaps\Services;

use SapiStudio\SapiMaps\Service as MapsService;

class Distance extends MapsService
{
    /**
     * Distance::getFormattedAddress()
     * 
     * @return
     */
    public function getFormattedAddress(){
        foreach($this->get() as $index => $response){
            $return[] = implode(' - ',array_column($response,'text'));
        }
        return $return;
    }
    
    /**
     * Distance::formatResponse()
     * 
     * @param mixed $response
     * @return
     */
    protected function formatResponse($response){
        return $response[0]['elements'];
    }
}