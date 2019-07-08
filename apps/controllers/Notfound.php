<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Notfound extends Alom {
    function index() {
        $this->load->view("notfound_view");
    }//End of index()
}//End of Notfound