<?php 
namespace SapiStudio\SapiMaps\Services;

use SapiStudio\SapiMaps\Service as MapsService;

class Directions extends MapsService
{
    /**
     * Directions::getOverview()
     * 
     * @return
     */
    public function getOverview(){
        return $this->get('overview_polyline.points');
    }
    
    /**
     * Directions::htmlInstructions()
     * 
     * @return
     */
    public function htmlInstructions(){
        return array_column($this->get('legs.0.steps'),'html_instructions');
    }
    
    /**
     * Directions::getDuration()
     * 
     * @return
     */
    public function getDuration(){
        return $this->get('legs.0.duration.text');
    }
    
    /**
     * Directions::getDistance()
     * 
     * @return
     */
    public function getDistance(){
        return $this->get('legs.0.distance.text');
    }
    
    /**
     * Directions::formatResponse()
     * 
     * @return
     */
    protected function formatResponse($response){
        return $response[0];
    }
}