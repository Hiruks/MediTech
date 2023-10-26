<?php 

class User_model extends CI_Model{
    
    public function loginCheck($data){
        $this->db->where('email',$data['email']);
        $this->db->where('password',$data['password']);
        $query = $this->db->get('users');
       
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function getUserData($data){
        $this->db->where('email',$data['email']);
        $this->db->where('password',$data['password']);
        $query = $this->db->get('users');
       
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

}

?>