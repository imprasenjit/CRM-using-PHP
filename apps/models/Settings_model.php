<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Settings_model extends CI_Model{
    function add_row($data){
        $this->db->insert("settings", $data); 
    }//End of add_row()
    
    function edit_row($id, $data){
        $this->db->where("setting_id", $id);
        $this->db->update("settings", $data);
        return true;
    }//End of edit_row()
    
    function get_rows(){
        $this->db->select("*");
        $this->db->from("settings"); 
        $this->db->where("setting_status", 1);
        $this->db->order_by("setting_id","DESC");
        $this->db->limit(1); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_rows()
    
    function get_row(){
        $this->db->select("*");
        $this->db->from("settings");
        $this->db->where("setting_id", 1);
        $this->db->order_by("setting_id","DESC");
        $this->db->limit(1); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }//End of if else
    }//End of get_row()
    
    function getdefultusr(){
        $this->db->select("*");
        $this->db->from("settings");
        $this->db->where("setting_id", 1);
        $this->db->order_by("setting_id","DESC");
        $this->db->limit(1); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return 1;
        } else {
            return $query->row()->assigneduser;
        }//End of if else
    }//End of get_row()
    
    function delete_row($id){
        $this->db->where("setting_id", $id);
        $this->db->delete("settings");
    }//End of if delete_row()
}//End of Settings_model