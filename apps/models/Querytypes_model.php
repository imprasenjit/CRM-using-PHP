<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Querytypes_model extends CI_Model{
    function add_row($data){
        $this->db->insert("querytypes", $data); 
    }//End of add_row()
    
    function edit_row($qtype_id, $data){
        $this->db->where("qtype_id", $qtype_id);
        $this->db->update("querytypes", $data);
        return true;
    }//End of edit_row()
    
    function delete_row($qtype_id){
        $this->db->where("qtype_id", $qtype_id);
        $this->db->delete("querytypes");
    }//End of if delete_row()
    
    function get_records(){
        $this->db->select("*");
        $this->db->from("querytypes"); 
        $this->db->where("qtype_status >=", 1); 
        $this->db->order_by("qtype_name","ASC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_rows()
    
    function get_rows($qtype_status=1){
        $this->db->select("*");
        $this->db->from("querytypes"); 
        $this->db->where("qtype_status", $qtype_status); 
        $this->db->order_by("qtype_name","ASC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_statusrows()
    
    function get_row($qtype_id){
        $this->db->select("*");
        $this->db->from("querytypes");
        $this->db->where("qtype_id", $qtype_id); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }//End of if else
    }//End of get_row()
}//End of Querytypes_model