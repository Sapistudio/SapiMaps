<?php 
namespace SapiStudio\SapiMaps\Services;

class Address extends \SapiStudio\SapiMaps\Service
{
    /** Address::load()*/
    public static function load($adresses = null){
        if($adresses['items']){
            foreach($adresses['items'] as $adressData)
                $return[] = new static($adressData);
        }
        return (count($return) == 1) ? $return[0] : $return;
    }
    
    /** Address::__construct()*/
    public function __construct($adressData){
        $this->responseData = $adressData;
        $this->formatResponse();
    }
    
    /**  Address::getAddresLabel() */
    public function getAddresLabel(){
        return $this->get('address.label');
    }
    
    /** Address::getAddresTitle()*/
    public function getAddresTitle(){
        return $this->get('title');
    }
    
    /**  Address::getAddresCountryName()*/
    public function getAddresCountryName(){
        return $this->get('address.countryName');
    }
    
    /** Address::getAddresCity()*/
    public function getAddresCity(){
        return $this->get('address.city');
    }
    
    /** Address::getAddresStreet()*/
    public function getAddresStreet(){
        return $this->get('address.street').' '.$this->get('address.houseNumber');
    }
    
    /** Address::getAddresZipCode() */
    public function getAddresZipCode(){
        return $this->get('address.postalCode');
    }
    
    /** Address::formatResponse()*/
    protected function formatResponse(){}
}