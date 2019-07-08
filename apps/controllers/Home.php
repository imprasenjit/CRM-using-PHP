<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Home extends Alom {
    function index() {
        $this->load->view("home_view");
    }//End of index()
}//End of Home