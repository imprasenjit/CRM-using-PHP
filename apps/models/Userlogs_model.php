<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Userlogs_model extends CI_Model{
    function get_userwise($uid){
        $this->db->select("*");
        $this->db->where("uid", $uid);
        $this->db->order_by("login_time","DESC"); 
        $this->db->limit(200);
        $this->db->from("userlogs");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_userwise() 
    
    function tot_rows(){
        $this->db->select("*");
        $this->db->from("userlogs");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_rows()
    
    function all_rows($limit, $start, $col, $dir){
        $this->db->select("*");
        $this->db->limit($limit, $start); 
        $this->db->order_by($col, $dir); 
        $this->db->from("userlogs");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return NULL;
        } else {
            return $query->result();
        }
    }//End of all_rows()
    
    function search_rows($limit, $start, $search, $col, $dir){
        $this->db->select("*");
        $this->db->like("uid", $search); 
        $this->db->or_like("login_time", $search);
        $this->db->limit($limit, $start); 
        $this->db->order_by($col, $dir); 
        $this->db->from("userlogs");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return NULL;
        } else {
            return $query->result();
        }
    }//End of search_rows()
    
    function tot_search_rows($search){
        $this->db->select("*");
        $this->db->like("uid", $search); 
        $this->db->or_like("login_time", $search); 
        $this->db->from("userlogs");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_search_rows()
    
    function delete_row($dt){
        $this->db->where("DATE(login_time) <", $dt);
        $this->db->delete("userlogs");
        return $this->db->affected_rows();
    }//End of if delete_row()
}//End of Userlogs_model