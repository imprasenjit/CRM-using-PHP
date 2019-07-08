<?php
class MY_Controller extends CI_Controller {
    function __construct() {
        parent::__construct();  
    }
} //End of MY_Controller

class Alom extends MY_Controller {
    function __construct() {
        parent::__construct();    
        //echo "I am inside Alom<br />";
    }
    
    function isloggedin($right = NULL){ //var_dump($this->session); die($right);
        if($this->session->session_login){           
            if(strlen($right)){
                if(isRight($right)) {
                    //$this->session->set_flashdata("accessMsg", "You have the permission : ".$right);
                } else {
                    $this->session->set_flashdata("accessMsg", "You do not have the permission to access this function!!!");
                    redirect(site_url("welcome"));                
                }//End of if else 
            } else {
               // $this->session->set_flashdata("accessMsg", "You have the permission to access this function");
            }//End of if else
	} else {
            $this->session->set_flashdata("accessMsg", "Session has been Expired!");
            redirect(site_url("signin"), "refresh");
        }//End of if else
    } //End of isloggedin()
    
    function isadmin(){
	if($this->session->session_utype != 1){
            $this->session->set_flashdata("accessMsg", "Access not allowed. Please contact your administrator");
            redirect(site_url("welcome")); 
	}
    } //End of isadmin()
} //End of Alom