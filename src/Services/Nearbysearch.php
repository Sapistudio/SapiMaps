<?php 
namespace SapiStudio\SapiMaps\Services;

use SapiStudio\SapiMaps\Service as MapsService;

class Nearbysearch extends MapsService
{
    /**
     * Nearbysearch::getResults()
     * 
     * @return
     */
    public function getResults(){
        $results = $this->get();
        if(!$results)
            return [];
        foreach($results as $index => $resultData){
            $return[$index]['location'] = implode(',',$resultData['geometry']['location']);
            $return[$index]['name'] = $resultData['name'];
            $return[$index]['vicinity'] = $resultData['vicinity'];
        }
        return $return;
    }
    
    /**
     * Nearbysearch::getFirst()
     * 
     * @return
     */
    public function getFirst(){
        return $this->getResults()[0];
    }
    
    /**
     * Nearbysearch::formatResponse()
     * 
     * @param mixed $response
     * @return
     */
    protected function formatResponse($response){
        return $response;
    }
}