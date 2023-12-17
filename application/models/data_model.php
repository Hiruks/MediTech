<?php

class Data_model extends CI_Model
{

    public function getMonthlySales($month)
    {
        $query = $this->db->query("SELECT * FROM `orders` WHERE MONTH(`created_date`) = $month");
        if ($query) {
            return $query->result();
        } else {
            
            echo $this->db->error();
            return false;
        }
    }

    public function getMonthlyCust($month)
    {
        $query = $this->db->query("SELECT * FROM `customers` WHERE MONTH(`registered_date`) = $month");
        if ($query) {
            return $query->result();
        } else {
            
            echo $this->db->error();
            return false;
        }
    }
}
