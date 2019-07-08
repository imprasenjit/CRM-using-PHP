<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Ticketreports_model extends CI_Model{
        
    function get_counts($fld1, $val1, $fld2=NULL, $val2=NULL){
        $this->db->select("support_time, support_status");        
        $this->db->from("supports");
        $this->db->where($fld1, $val1);
        if(strlen($fld2)) {
            $this->db->where($fld2, $val2);
        }        
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of get_counts()
        
    function tot_rows($fld1, $val1){
        $this->db->select("*");
        $this->db->where($fld1, $val1);
        $this->db->from("supports");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_rows()
    
    function all_rows($fld1, $val1, $limit, $start, $col, $dir){
        $this->db->select("*");
        $this->db->where($fld1, $val1);
        $this->db->limit($limit, $start); 
        $this->db->order_by($col, $dir); 
        $this->db->from("supports");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return NULL;
        } else {
            return $query->result();
        }
    }//End of all_rows()
    
    function search_rows($fld1, $val1, $limit, $start, $search, $col, $dir){
        $this->db->select("*");
        $this->db->where($fld1, $val1);
        $this->db->like("email", $search); 
        $this->db->or_like("cno", $search);
        $this->db->or_like("ubin", $search);
        $this->db->or_like("cname", $search);
        $this->db->or_like("ticket_no", $search);
        $this->db->limit($limit, $start); 
        $this->db->order_by($col, $dir); 
        $this->db->from("supports");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return NULL;
        } else {
            return $query->result();
        }
    }//End of search_rows()
    
    function tot_search_rows($fld1, $val1, $search){
        $this->db->select("*");
        $this->db->where($fld1, $val1);
        $this->db->like("email", $search); 
        $this->db->or_like("cno", $search);
        $this->db->or_like("ubin", $search);
        $this->db->or_like("cname", $search);
        $this->db->or_like("ticket_no", $search);
        $this->db->from("supports");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_search_rows()
}//End of Ticketreports_model