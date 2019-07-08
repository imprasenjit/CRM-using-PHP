<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Users_model extends CI_Model{
    function add_row($data){
        $this->db->insert("users", $data); 
    }//End of add_row()
    
    function edit_row($id, $data){
        $this->db->where("uid", $id);
        $this->db->update("users", $data);
        return true;
    }//End of edit_row()
    
    function get_rows(){
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("status", 1);
        $this->db->where("uname !=", "alom");
        $this->db->order_by("user_name","ASC");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_rows()
    
    function get_staffrows(){
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("status", 1);
        $this->db->where("utype !=", 4);
        $this->db->where("uname !=", "alom");
        $this->db->order_by("user_name","ASC");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_staffrows()
    
    function get_deptrows(){
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("status", 1);
        $this->db->where("utype", 4);
        $this->db->order_by("user_name","ASC");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_deptrows()
    
    function get_row($id){
        $this->db->select("*");
        $this->db->from("users"); 
        $this->db->where("status", 1);
        $this->db->where("uid", $id); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }//End of if else
    }//End of get_row()
    
    function delete_row($id){
        $this->db->where("uid", $id);
        $this->db->delete("users");
    }//End of if delete_row()
}//End of Users_model
