<?php

class User_model extends CI_Model
{

    // ----------------------Product Model----------------------------

    public function editProductData($id, $data)
    {

        $condition = "productID='{$id}'";
        //$this->db->set('userType', $data['userType']);
        $this->db->set('title', $data['title']);
        $this->db->set('description', $data['description']);
        $this->db->set('img', $data['img']);
        $this->db->set('price', $data['price']);


        $this->db->where($condition);
        $this->db->update('products');

        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }

    public function delProduct($id)
    {
        //DELETE FROM customers WHERE `customers`.`custID` = 19
        $condition = "productID='{$id}'";
        $this->db->where($condition);
        $this->db->delete('products');
        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }



    public function fetchProducts()
    {

        $query = $this->db->query("SELECT * FROM `products`");

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function addProduct($data)
    {

        $this->db->set('title', $data['title']);
        $this->db->set('description', $data['description']);
        $this->db->set('img', $data['img']);
        $this->db->set('price', $data['price']);


        $query = $this->db->insert('products');

        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }

    public function getProductByID($id)
    {
        $condition = "productID='{$id}'";
        $query = $this->db->select('*')
            ->where($condition)
            ->get('products');

        return $query->result();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    // ----------------------Customer Model----------------------------

    public function fetchBlacklistedCustomers()
    {

        $query = $this->db->query("SELECT * FROM `customers` WHERE `status` = 'blacklisted'");
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function fetchCustomerDB()
    {

        $query = $this->db->query("SELECT * FROM `customers`");

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function fetchWhitelistedCustomerDB()
    {
        $condition = "`status` = 'whitelisted'";

        $query = $this->db->select('*')
            ->where($condition, NULL, FALSE)
            ->get('customers');;

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getCustomerDataByID($id)
    {
        $condition = "custID='{$id}'";
        $query = $this->db->select('*')
            ->where($condition)
            ->get('customers');

        return $query->result();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getCustomerNameByID($id)
    {
        $condition = "custID='{$id}'";

        $query = $this->db->select('*')
            ->where($condition)
            ->get('customers');

        return $query->result();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function fetchOrderNames()
    {

        $query = $this->db->query("SELECT `name` FROM `customers`");

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function searchBlacklistByName($name)
    {
        $condition = "name LIKE '%{$name}%'";
        $condition2 = "`status` = 'blacklisted'";
        $query = $this->db->select('*')
            ->where($condition, NULL, FALSE)
            ->where($condition2, NULL, FALSE)
            ->get('customers');


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchCustomerByName($name)
    {
        $condition = "name LIKE '%{$name}%'";
        $condition2 = "`status` = 'whitelisted'";

        $query = $this->db->select('*')
            ->where($condition, NULL, FALSE)
            ->where($condition2, NULL, FALSE)
            ->get('customers');


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }



    public function editCustomerData($id, $customer)
    {

        $condition = "custID='{$id}'";
        //$this->db->set('userType', $data['userType']);
        $this->db->set('name', $customer['name']);
        $this->db->set('email', $customer['email']);
        $this->db->set('contactNo', $customer['contactNo']);

        $this->db->where($condition);
        $this->db->update('customers');

        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }

    public function addCustomer($data)
    {

        $this->db->set('email', $data['email']);
        $this->db->set('name', $data['name']);
        $this->db->set('contactNo', $data['contactNo']);

        $query = $this->db->insert('customers');

        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }

    public function delCustomer($id)
    {
        //DELETE FROM customers WHERE `customers`.`custID` = 19
        $condition = "custID='{$id}'";
        $this->db->where($condition);
        $this->db->delete('customers');
        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    // ----------------------User Profile Model----------------------------

    public function getUserTypes()
    {
        $sql = "SELECT SUBSTRING(COLUMN_TYPE, 6, LENGTH(COLUMN_TYPE) - 6) AS enum_values "
            . "FROM information_schema.COLUMNS "
            . "WHERE TABLE_NAME = 'users' AND COLUMN_NAME = 'userType';";

        $query = $this->db->query($sql);

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function getUserData($data)
    {
        $this->db->where('email', $data['email']);
        $this->db->where('password', $data['password']);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getUserDataByID($id)
    {
        $condition = "userid='{$id}'";
        $query = $this->db->select('*')
            ->where($condition)
            ->get('users');

        // return $query->result();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function updateProfile($data)
    {
        $condition = "userid='{$data['id']}'";
        //$this->db->set('userType', $data['userType']);
        $this->db->set('email', $data['email']);
        $this->db->set('name', $data['name']);
        $this->db->set('contactNo', $data['contact']);

        $this->db->where($condition);
        $this->db->update('users');

        // echo $this->db->last_query();
        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }

    public function fetchUserDB()
    {

        $query = $this->db->query("SELECT * FROM `users`");

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addUser($data)
    {

        $this->db->set('email', $data['email']);
        $this->db->set('name', $data['name']);
        $this->db->set('contactNo', $data['contactNo']);
        $this->db->set('branchID', $data['branchID']);
        $this->db->set('password', $data['password']);
        $this->db->set('userType', $data['userType']);

        $query = $this->db->insert('users');

        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }

    public function editUserData($id, $data)
    {

        $condition = "userid='{$id}'";
        //$this->db->set('userType', $data['userType']);
        $this->db->set('email', $data['email']);
        $this->db->set('name', $data['name']);
        $this->db->set('contactNo', $data['contactNo']);
        $this->db->set('branchID', $data['branchID']);
        $this->db->set('password', $data['password']);
        $this->db->set('userType', $data['userType']);

        $this->db->where($condition);
        $this->db->update('users');

        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }

    public function delUser($id)
    {
        //DELETE FROM customers WHERE `customers`.`custID` = 19
        $condition = "userid='{$id}'";
        $this->db->where($condition);
        $this->db->delete('users');
        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    // ----------------------Login Model----------------------------

    public function loginCheck($data)
    {
        $this->db->where('email', $data['email']);
        $this->db->where('password', $data['password']);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // ----------------------Order Model----------------------------

    public function fetchCreditTermsDB()
    {

        $query = $this->db->query("SELECT * FROM `creditterms`");

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function fetchOrdersWCustomers()
    {
        $query = $this->db->query("SELECT orders.*,customers.name FROM orders orders, customers customers where customers.custID = orders.custID");

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function fetchOrdersWCustomerID($id)
    {
        $query = $this->db->query("SELECT * FROM orders JOIN customers ON customers.custID = orders.custID WHERE orders.id = $id");
        //print_r($query->result());
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function fetchOrdersWCreditTerms($id)
    {
        $query = $this->db->query("SELECT * FROM orders JOIN creditterms ON creditterms.id = orders.creditTermID WHERE orders.id = $id");
        //print_r($query->result());
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getOrderProducts($id)
    {
        $sql = "SELECT products.*, order_products.*
          FROM order_products
          INNER JOIN products ON order_products.product_id = products.productID
          WHERE order_products.order_id = $id";

        $query = $this->db->query($sql);
        //print_r($query->result());
        
        
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addOrder($data)
    {

        $this->db->set('custID', $data['custID']);
        $this->db->set('value', $data['value']);
        $this->db->set('creditTermID', $data['creditTermsID']);


        $query = $this->db->insert('orders');

        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }

    public function updatePayment($id)
    {
        $condition = "id='{$id}'";

        $this->db->set('isPaid', 1);
        $this->db->where($condition);
        $this->db->update('orders');

        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }

    public function addConfirmationRecord($data)
    {

        $this->db->set('orderID', $data['orderID']);
        $this->db->set('img', $data['img']);
        $this->db->set('reciptNo', $data['reciptNo']);


        $query = $this->db->insert('payment_records');

        if ($this->db->affected_rows() == 1) {
            return (1);
        } else if ($this->db->affected_rows() == 0) {
            return (0);
        } else {
            return (-1);
        }
    }



    public function searchOrderByName($name)
    {
        $condition = "name LIKE '%{$name}%'";

        $query = $this->db->query("SELECT orders.*,customers.name FROM orders orders, customers customers where customers.custID = orders.custID AND $condition");


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}
