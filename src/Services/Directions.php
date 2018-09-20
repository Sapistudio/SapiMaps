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
     * Directions::getStartAddress()
     * 
     * @return
     */
    public function getStartAddress(){
        return $this->get('legs.0.start_address');
    }
    
    /**
     * Directions::getStartLocation()
     * 
     * @return
     */
    public function getStartLocation(){
        return implode(',',$this->get('legs.0.start_location'));
    }
    
    /**
     * Directions::getEndAddress()
     * 
     * @return
     */
    public function getEndAddress(){
        return $this->get('legs.0.end_address');
    }
    
    /**
     * Directions::getStartLocation()
     * 
     * @return
     */
    public function getEndLocation(){
        return implode(',',$this->get('legs.0.end_location'));
    }
    
    
    /**
     * Directions::getStaticMap()
     * 
     * @return
     */
    public function getStaticMap($size = "1200x400"){
        $markers = [];
        $waypoints_labels = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K"];
        $waypoints_label_iter = 0;
        $markers[] = "markers=color:green" . urlencode("|") . "label:" . urlencode($waypoints_labels[$waypoints_label_iter++] . '|' . $this->getStartLocation());
        $markers[] = "markers=color:red" . urlencode("|") . "label:" . urlencode($waypoints_labels[$waypoints_label_iter] . '|' . $this->getEndLocation());
        return 'https://maps.googleapis.com/maps/api/staticmap?size='.$size.'&maptype=roadmap&path=enc:'.$this->getOverview().'&'.implode($markers, '&').'&key='.$this->handler->getApiKey();
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