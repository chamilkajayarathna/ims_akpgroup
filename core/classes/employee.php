<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employee
 *
 * @author Niranjana
 */
class employee {
    
    public $serial_no;
    public $designation;
    public $name;
    public $epf_no;
    public $appoinment_date;
    
    public $nic;
    public $dob;
    public $address;
    public $contact;
    public $workSite;
    public $img;
    
    public $basicSalary;
    public $workTarget;
    public $spIntencive;
    public $difficult;
    public $other;
    
    public function __construct() {
        
    }
    
    //Set Methods
    public function setSerial_no($serial_no) { $this->serial_no = $serial_no; }
    public function setDesignation($designation) { $this->designation = $designation; }
    public function setName($name) { $this->name = $name; }
    public function setEpf_no($epf_no) { $this->epf_no = $epf_no; }
    public function setAppoinment_date($appoinment_date) { $this->appoinment_date = $appoinment_date; }
    
    public function setNic($nic) { $this->nic = $nic; }
    public function setDob($dob) { $this->dob = $dob; }
    public function setAddress($address) { $this->address = $address; }
    public function setContact($contact) { $this->contact = $contact; }
    public function setWorkSite($workSite) { $this->workSite = $workSite; }
    public function setImg($img) { $this->img = $img; }
    
    public function setBasicSalary($basicSalary) { $this->basicSalary = $basicSalary; }
    public function setWorkTarget($workTarget) { $this->workTarget = $workTarget; }
    public function setSpIntencive($spIntencives) { $this->spIntencive = $spIntencives; }
    public function setDifficulte($difficult) { $this->difficult = $difficult; }
    public function setOther($other) { $this->other = $other; }
    
    //Get methods  
    public function getSerial_no() { return $this->serial_no ; }
    public function getDesignation() { return $this->designation ; }
    public function getName() { return $this->name ; }
    public function getEpf_no() { return $this->epf_no ; }
    public function getAppoinment_date() { return $this->appoinment_date ; }
    
    public function getNic() { return $this->nic; }
    public function getDob() { return $this->dob ; }
    public function getAddress() { return $this->address; }
    public function getContact() { return $this->contact; }
    public function getWorkSite() { return $this->workSite; }
    public function getImg() { return $this->img; }
    
    public function getBasicSalary() { return $this->basicSalary; }
    public function getWorkTarget() { return $this->workTarget; }
    public function getSpIntencive() { return $this->spIntencive; }
    public function getDifficulte() { return $this->difficult; }
    public function getOther() { return $this->other; }
}
