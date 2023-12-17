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

    public function getCreditTermsNo()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total_entries FROM creditterms;
        ");
        if ($query) {
            $result = $query->row();
            return (int)$result->total_entries;
        } else {
            return false;
        }
    }

    public function fetchCreditTerms()
    {

        $query = $this->db->query("SELECT * FROM `creditterms`");

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function fetchOverdueOrders()
    {

        $condition = "isOverdue='1'";
        $query = $this->db->select('*')
            ->where($condition)
            ->get('orders');

        // return $query->result();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return 0;
        }
    }

    public function findOverdueMonth($id)
    {
        $query = $this->db->select('overdue_period')->where('id', $id)->get('creditterms');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            $overduePeriod = $result->overdue_period;
            return $overduePeriod;
        } else {
            return false;
        }
    }

    public function findBlacklistMonth($id)
    {
        $query = $this->db->select('blacklisted_period')->where('id', $id)->get('creditterms');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            $blacklistedPeriod = $result->blacklisted_period;
            return $blacklistedPeriod;
        } else {
            return false;
        }
    }

    public function updateOverdueOrderPerTerm($term, $m)
    {
        $condition = "creditTermID='{$term}' AND isPaid = 0 AND created_date < DATE_SUB(NOW(), INTERVAL {$m} MONTH)";

        // Update the orders that meet the conditions
        $this->db->set('isOverdue', 1)
            ->where($condition)
            ->update('orders');

        // Check if any rows were affected
        return $this->db->affected_rows();
    }

    public function findBlacklistableUsers($term, $m)
    {
        $condition = "creditTermID='{$term}' AND isPaid = 0 AND isOverdue = 1 AND created_date < DATE_SUB(NOW(), INTERVAL {$m} MONTH)";

        // Update the orders that meet the conditions
        $query=$this->db->select('*')
            ->where($condition)
            ->get('orders');

            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
    }

    public function blacklistCustomers($id)
    {
        $condition = "custID='{$id}'";

        // Update the orders that meet the conditions
        $this->db->set('status', 'blacklisted')
            ->where($condition)
            ->update('customers');

        // Check if any rows were affected
        return $this->db->affected_rows();
    }
}
