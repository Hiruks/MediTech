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

    public function getUserDataByID($id){
        $condition = "userid='{$id}'";
        $query = $this->db->select('*')
                        ->where($condition)
                        ->get('users');
        
        // return $query->result();
        if($query->num_rows() == 1){
            return $query->result();
        }else{
            return false;
        }
    }

    public function updateProfile($data){
        $condition ="userid='{$data['id']}'";
        //$this->db->set('userType', $data['userType']);
        $this->db->set('email', $data['email']);
        $this->db->set('name', $data['name']);
        $this->db->set('contactNo', $data['contact']);

        $this->db->where($condition);
        $this->db->update('users');

         // echo $this->db->last_query();
        if($this->db->affected_rows() == 1){
            return(1);
        }else if($this->db->affected_rows() == 0){
            return(0);
        }else{
            return(-1);
        }
    }

}

?>