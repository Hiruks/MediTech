<?php

class Data_model extends CI_Model
{

    public function getMonthlySales($month)
    {
        if ($month <= 12) {
            $query = $this->db->query("SELECT * FROM `orders` WHERE MONTH(`created_date`) = $month");
            if ($query) {
                return $query->result();
            } else {

                echo $this->db->error();
                return false;
            }
        } else {
            $query = $this->db->query("SELECT * FROM `orders` WHERE YEAR(`created_date`) = $month");
            if ($query) {
                return $query->result();
            } else {

                echo $this->db->error();
                return false;
            }
        }
    }

    public function getMonthlyCust($month)
    {
        if ($month <= 12) {
            $query = $this->db->query("SELECT * FROM `customers` WHERE MONTH(`registered_date`) = $month");
            if ($query) {
                return $query->result();
            } else {

                echo $this->db->error();
                return false;
            }
        } else {
            $query = $this->db->query("SELECT * FROM `customers` WHERE YEAR(`registered_date`) = $month");
            if ($query) {
                return $query->result();
            } else {

                echo $this->db->error();
                return false;
            }
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

    public function fetchOverdueOrders($m)
    {
        if ($m <= 12) {
            $condition = "isOverdue='1'";
            $condition2 = "MONTH(`created_date`) = $m";
            $query = $this->db->select('*')
                ->where($condition)
                ->where($condition2)
                ->get('orders');

            // return $query->result();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return 0;
            }
        } else {
            $condition = "isOverdue='1'";
            $condition2 = "YEAR(`created_date`) = $m";
            $query = $this->db->select('*')
                ->where($condition)
                ->where($condition2)
                ->get('orders');

            // return $query->result();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return 0;
            }
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
        $condition = "creditTermID='{$term}' AND isPaid = 0 AND isOverdue = 0 AND created_date < DATE_SUB(NOW(), INTERVAL {$m} MONTH)";
        
        $query = $this->db->select('*')
                ->where($condition)->get('orders');
        // Update the orders that meet the conditions
        $this->db->set('isOverdue', 1)
            ->where($condition)
            ->update('orders');

        // Check if any rows were affected
        return $query->result();
    }

    public function findBlacklistableUsers($term, $m)
    {
        $condition = "creditTermID='{$term}' AND isPaid = 0 AND isOverdue = 1 AND created_date < DATE_SUB(NOW(), INTERVAL {$m} MONTH)";

        // Update the orders that meet the conditions
        $query = $this->db->select('*')
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

    public function getOrderCustomerID($id)
    {
        $condition = "id='{$id}'";

        // Update the orders that meet the conditions
        $query = $this->db->select('custID')
            ->where($condition)
            ->get('orders');

        if ($query->num_rows() > 0) {
            $result = $query->row();
            $cust = $result->custID;
            return $cust;
        } else {
            return false;
        }
    }

    public function orderByCustomers($custID, $id)
    {
        $condition1 = "custID='{$custID}'";
        $condition2 = "creditTermID='{$id}'";

        // Update the orders that meet the conditions
        $query = $this->db->select('*')
            ->where($condition1)
            ->where($condition2)
            ->get('orders');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function isBlacklisted($id, $m)
    {
        $condition = "id='{$id}' AND created_date < DATE_SUB(NOW(), INTERVAL {$m} MONTH)";

        // Update the orders that meet the conditions
        $query = $this->db->select('*')
            ->where($condition)
            ->get('orders');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function whitelistCustomer($id)
    {
        $condition = "custID='{$id}'";

        // Update the orders that meet the conditions
        $this->db->set('status', 'whitelisted')
            ->where($condition)
            ->update('customers');

        // Check if any rows were affected
        return $this->db->affected_rows();
    }
}
