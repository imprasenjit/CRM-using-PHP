<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Supportprocess_model extends CI_Model{
    function add_row($data){
        $this->db->insert("supportprocess", $data); 
    }//End of add_row()
    
    function edit_row($id, $data){
        $this->db->where("process_id", $id);
        $this->db->update("supportprocess", $data);
        return true;
    }//End of edit_row()
    
    function get_rows(){
        $this->db->select("*");
        $this->db->from("supportprocess"); 
        //$this->db->where("process_status", 1); 
        $this->db->order_by("process_time","DESC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_rows()
    
    function get_supportrows($support_id){
        $this->db->select("*");
        $this->db->from("supportprocess"); 
        $this->db->where("support_id", $support_id); 
        $this->db->order_by("process_time","ASC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_supportrows()
    
    function get_replyrows($support_id){
        $query = $this->db->query("SELECT * FROM supportprocess WHERE (support_id='$support_id') AND (process_type='2' OR process_type='5' OR process_type='6') ORDER BY process_time ASC");
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_replyrows()
    
    function get_lastrows(){
        $this->db->select("*");
        $this->db->from("supportprocess");
        $this->db->order_by("process_time","DESC");
        $this->db->limit(5);
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_lastrows()
    
    function get_row($id){
        $this->db->select("*");
        $this->db->from("supportprocess");
        $this->db->where("process_id", $id); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }//End of if else
    }//End of get_row()
    
    function get_emailrow($email){
        $this->db->select("email, cno, cname, caddress, ubin");
        $this->db->from("supportprocess");
        $this->db->where("email", $email);
        $this->db->order_by("process_time","DESC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row_array();
        }//End of if else
    }//End of get_emailrow()
    
    function delete_row($id){
        $this->db->where("process_id", $id);
        $this->db->delete("supportprocess");
    }//End of if delete_row()
}//End of Supportprocess_model
