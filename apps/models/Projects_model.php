<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Projects_model extends CI_Model{
    function add_row($data){
        $this->db->insert("projects", $data); 
    }//End of add_row()
    
    function edit_row($id, $data){
        $this->db->where("project_id", $id);
        $this->db->update("projects", $data);
        return true;
    }//End of edit_row()
    
    function get_rows(){
        $this->db->select("*");
        $this->db->from("projects"); 
        $this->db->where("project_status", 1); 
        $this->db->order_by("company_name","ASC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_rows()
    
    function get_row($id){
        $this->db->select("*");
        $this->db->from("projects"); 
        $this->db->where("project_status", 1);
        $this->db->where("project_id", $id); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }//End of if else
    }//End of get_row()
    
    function delete_row($id){
        $this->db->where("project_id", $id);
        $this->db->delete("projects");
    }//End of if delete_row()
}//End of Projects_model