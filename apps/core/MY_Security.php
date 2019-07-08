<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class MY_Security extends CI_Security {

    public function csrf_show_error() {
        $heading = "Be gone fool!";
        $message = "You shall not pass!";
        $_error = & load_class('Exceptions', 'core');
        echo $_error->show_error($heading, $message, 'csrf_error', 403);
        exit;
    }
}
