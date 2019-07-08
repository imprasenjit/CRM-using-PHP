<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
class Welcome extends Alom {
    function index() {
        $this->isloggedin();
        $this->load->helper("text");
        $this->load->helper("ticketstatus");
        $this->load->model("supports_model");
        $this->load->model("ticketsnew_model");
        $this->load->model("ticketsopen_model");
        $this->load->model("ticketsclose_model");
        $this->load->model("tickets_model");
        $this->load->model("querytypes_model");
        $this->load->model("calls_model");
        if($this->session->session_utype == 1) {
            $this->load->view("welcomeadmin_view");
        } else {
            $this->load->view("welcomeuser_view");
        }
        
    }//End of index()

    function updatedb() {
        $this->isloggedin();
        //$qry = "CREATE TABLE `settings` ( `setting_id` INT NOT NULL AUTO_INCREMENT , `superuser` INT NOT NULL , `assigneduser` INT NOT NULL , `setting_status` TINYINT NOT NULL , PRIMARY KEY (`setting_id`)) ENGINE = InnoDB;";
        $qry = "INSERT INTO settings(superuser, assigneduser) VALUES('1','1')";
        //$qry = "ALTER TABLE supports CHANGE support_time support_time TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL;";
        $this->db->query($qry);
        //$this->db->query("ALTER TABLE supports ADD query_file VARCHAR(255) AFTER query");
        //$this->db->query("ALTER TABLE supportprocess ADD process_file VARCHAR(255) AFTER process_msg");
    }//End of updatedb()
}//End of Welcome
