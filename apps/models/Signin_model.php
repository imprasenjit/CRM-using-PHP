<?php
if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Signin_model extends CI_Model {
    public function process($uname, $pass) {            
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("uname", $uname);
        $this->db->where("status", 1);
        $qry = $this->db->get();
        if ($qry->num_rows() == 1) {
            $row = $qry->row();
            $dbpassword = $row->pass;
            if (crypt($pass, $dbpassword) == $dbpassword) {
                $uid = $row->uid;
                $name = $row->user_name;
                $utype = $row->utype;
                $user_rights = $row->user_rights;
                $this->load->helper("userinfo");
                $systeminfo = infos();
                $logdata = array(
                    "uid" => $uid,
                    "login_time" => date("Y-m-d H:i:s"),
                    "system_info" => $systeminfo
                );
                $this->logssave($logdata);
                $log_id = $this->db->insert_id();
                
                $sessiondata = array(
                    "session_uid" => $uid,
                    "session_username" => $name,
                    "session_uname" => $uname,
                    "session_utype" => $utype,
                    "session_rights" => $user_rights,
                    "session_logid" => $log_id,
                    "session_login" => true
                );
                session_regenerate_id(true);
                $this->session->set_userdata($sessiondata);
                return TRUE;
            } else {
                //return FALSE;            
                if($dbpassword == MD5($pass)) {                    
                    $uid = $row->uid;
                    $name = $row->user_name;
                    $utype = $row->utype;
                    $school_id = $row->school_id;
                    $this->load->helper("userinfo");
                    $systeminfo = infos();
                    $logdata = array(
                        "uid" => $uid,
                        "login_time" => date("Y-m-d H:i:s"),
                        "system_info" => $systeminfo
                    );
                    $this->logssave($logdata);
                    $log_id = $this->db->insert_id();

                    $sessiondata = array(
                        "session_uid" => $uid,
                        "session_schoolid" => $school_id,
                        "session_username" => $name,
                        "session_uname" => $uname,
                        "session_utype" => $utype,
                        "session_logid" => $log_id,
                        "session_login" => true
                    );
                    $this->session->set_userdata($sessiondata);                    
                    
                    //Update Pass
                    $mdPass = MD5($pass);
                    $salt = uniqid("", true);
                    $algo = "6";
                    $rounds = "5050";
                    $cryptSalt = '$' . $algo . '$rounds=' . $rounds . '$' . $salt;
                    $hashedPassword = crypt($pass, $cryptSalt);
                    $this->load->model("admin/users_model");
                    $this->users_model->edit_row($uid, array("pass" => $hashedPassword));
                    return TRUE;
                } else {
                    return FALSE;
                }                    
            }
        } else {
            return FALSE;
        }
    }//End of process

    public function logssave($data) {
        $this->db->insert("userlogs", $data);
        return true;
    }// End of logssave

    public function logsupdate($log_id) {
        $currentTime = date("Y-m-d H:i:s");
        $this->db->where("log_id", $log_id);
        $this->db->update("userlogs", array("logout_time" => $currentTime));
        return true;
    }// End of logsupdate    
}// End of Signin_model 