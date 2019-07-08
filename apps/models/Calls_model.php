<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Calls_model extends CI_Model{
    function add_row($data){
        $this->db->insert("calls", $data); 
    }//End of add_row()
    
    function edit_row($id, $data){
        $this->db->where("call_id", $id);
        $this->db->update("calls", $data);
        return true;
    }//End of edit_row()
    
    function get_rows(){
        $this->db->select("*");
        $this->db->from("calls"); 
        //$this->db->where("call_status", 1); 
        $this->db->order_by("call_time","DESC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_rows()
    
    function get_userrows($uid){
        $this->db->select("*");
        $this->db->from("calls"); 
        $this->db->where("uid", $uid); 
        $this->db->order_by("call_time","DESC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_userrows()
    
    function get_lastrows(){
        $this->db->select("*");
        $this->db->from("calls");
        $this->db->order_by("call_time","DESC");
        $this->db->limit(15);
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_lastrows()
    
    function get_row($id){
        $this->db->select("*");
        $this->db->from("calls");
        $this->db->where("call_id", $id); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }//End of if else
    }//End of get_row()
    
    function get_cnorow($cno){
        $this->db->select("cno, email, cname, caddress");
        $this->db->from("calls");
        $this->db->where("cno", $cno);
        $this->db->order_by("call_time","DESC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row_array();
        }//End of if else
    }//End of get_cnorow()
        
    function get_datecalls($dt){
        $this->db->select("call_time, COUNT(call_id) as tot_calls");        
        $this->db->from("calls");
        $this->db->group_by("DATE(call_time)");
        $this->db->where("DATE(call_time)", $dt);
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->row();
        }//End of if else
    }//End of get_datecalls()
    
    function delete_row($id){
        $this->db->where("call_id", $id);
        $this->db->delete("calls");
    }//End of if delete_row()
       
    //Datatable records
    function tot_rows(){
        $this->db->select("*");
        $this->db->from("calls");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_rows()
    
    function all_rows($limit, $start, $col, $dir){
        $this->db->select("*");
        $this->db->limit($limit, $start); 
        $this->db->order_by($col, $dir); 
        $this->db->from("calls");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return NULL;
        } else {
            return $query->result();
        }
    }//End of all_rows()
    
    function search_rows($limit, $start, $search, $col, $dir){
        $this->db->select("*");
        $this->db->like("email", $search); 
        $this->db->or_like("cno", $search);
        $this->db->or_like("cname", $search);
        $this->db->limit($limit, $start); 
        $this->db->order_by($col, $dir); 
        $this->db->from("calls");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return NULL;
        } else {
            return $query->result();
        }
    }//End of search_rows()
    
    function tot_search_rows($search){
        $this->db->select("*");
        $this->db->like("email", $search); 
        $this->db->or_like("cno", $search);
        $this->db->or_like("cname", $search);
        $this->db->from("calls");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_search_rows()
}//End of Calls_model
