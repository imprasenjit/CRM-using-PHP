<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Supports_model extends CI_Model{
    function add_row($data){
        $this->db->insert("supports", $data); 
    }//End of add_row()
    
    function edit_row($id, $data){
        $this->db->where("support_id", $id);
        $this->db->update("supports", $data);
        return true;
    }//End of edit_row()
    
    function get_rows(){
        $this->db->select("*");
        $this->db->from("supports");
        $this->db->order_by("support_id","DESC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_rows()
    
    function get_lastrows(){
        $this->db->select("*");
        $this->db->from("supports");
        $this->db->order_by("support_time","DESC");
        $this->db->limit(15);
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_lastrows()
    
    function get_lastuserrows($uid){
        $this->db->select("*");
        $this->db->from("supports");
        $this->db->where("uid", $uid);
        $this->db->order_by("support_time","DESC");
        $this->db->limit(15);
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_lastuserrows()
    
    function get_row($id){
        $this->db->select("*");
        $this->db->from("supports");
        $this->db->where("support_id", $id); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }//End of if else
    }//End of get_row()
    
    function get_trackrow($ticket_no){
        $this->db->select("*");
        $this->db->from("supports");
        $this->db->where("ticket_no", $ticket_no);
        $this->db->order_by("support_id","DESC"); 
        $this->db->limit(1);
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }//End of if else
    }//End of get_trackrow()
    
    function get_emailrow($email){
        $this->db->select("email, cno, cname, caddress, ubin");
        $this->db->from("supports");
        $this->db->where("email", $email);
        $this->db->order_by("support_time","DESC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row_array();
        }//End of if else
    }//End of get_emailrow()
    
    function delete_row($id){
        $this->db->where("support_id", $id);
        $this->db->delete("supports");
    }//End of if delete_row()
}//End of Supports_model
