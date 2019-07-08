<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class Ticketsopen_model extends CI_Model{
    function get_rows(){
        $this->db->select("*");
        $this->db->from("supports");
        $this->db->where("support_status >", 1);
        $this->db->where("support_status <", 5);
        $this->db->order_by("support_id","DESC");  
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_rows()
    
    function tot_rows(){
        $this->db->select("*");
        $this->db->where("support_status >", 1);
        $this->db->where("support_status <", 5);
        $this->db->from("supports");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_rows()
    
    function all_rows($limit, $start, $col, $dir){
        $this->db->select("*");
        $this->db->where("support_status >", 1);
        $this->db->where("support_status <", 5);
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
    
    function search_rows($limit, $start, $search, $col, $dir){
        $this->db->select("*");
        $this->db->where("support_status >", 1);
        $this->db->where("support_status <", 5);
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
    
    function tot_search_rows($search){
        $this->db->select("*");
        $this->db->where("support_status >", 1);
        $this->db->where("support_status <", 5);
        $this->db->like("email", $search); 
        $this->db->or_like("cno", $search);
        $this->db->or_like("ubin", $search);
        $this->db->or_like("cname", $search);
        $this->db->or_like("ticket_no", $search);
        $this->db->from("supports");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_search_rows()
    
    //USER WISE ROWS    
    function get_userrows($uid){
        $this->db->select("*");
        $this->db->where("uid", $uid);
        $this->db->where("support_status >=", 1);
        $this->db->where("support_status <", 5);
        $this->db->order_by("support_status","DESC");
        $this->db->order_by("support_time","DESC"); 
        $this->db->from("supports"); 
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }//End of if else
    }//End of get_userrows()
    
    function tot_userrows($uid){
        $this->db->select("*");
        $this->db->where("uid", $uid);
        $this->db->where("support_status >=", 1);
        $this->db->where("support_status <", 5);
        $this->db->from("supports");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_userrows()
    
    function all_userrows($uid, $limit, $start, $col, $dir){
        $this->db->select("*");
        $this->db->where("uid", $uid);
        $this->db->where("support_status >=", 1);
        $this->db->where("support_status <", 5);
        $this->db->limit($limit, $start); 
        $this->db->order_by($col, $dir); 
        $this->db->from("supports");
        $query = $this->db->get(); 
        if($query->num_rows() == 0) {
            return NULL;
        } else {
            return $query->result();
        }
    }//End of all_userrows()
    
    function search_userrows($uid, $limit, $start, $search, $col, $dir){
        $this->db->select("*");
        $this->db->where("uid", $uid);
        $this->db->where("support_status >=", 1);
        $this->db->where("support_status <", 5);
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
    }//End of search_userrows()
    
    function tot_search_userrows($uid, $search){
        $this->db->select("*");
        $this->db->where("uid", $uid);
        $this->db->where("support_status >=", 1);
        $this->db->where("support_status <", 5);
        $this->db->like("email", $search); 
        $this->db->or_like("cno", $search);
        $this->db->or_like("ubin", $search);
        $this->db->or_like("cname", $search);
        $this->db->or_like("ticket_no", $search);
        $this->db->from("supports");
        $query = $this->db->get(); 
        return $query->num_rows();
    }//End of tot_search_userrows()
}//End of Ticketsopen_model
