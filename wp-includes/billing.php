<?php

class Billings
{
    private $conn;
    public $tbl_name = "tbl_billings";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    public function addLogs($user_id, $actions)
    {

        $date = new DateTime("now", new DateTimeZone('Asia/Manila'));
        $current = $date->format('Y-m-d H:i:s');

        $date = date('Y-m-d h:i:s', strtotime('now'));
        $this->conn->query("INSERT INTO tbl_logs(user_id, action, date) VALUES('{$user_id}', '{$actions}', '{$current}')");
    }

    public function addBilling($user_id, $billing_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $zipcode)
    {
        $billing_query = $this->conn->query("INSERT INTO {$this->tbl_name}(user_id, billing_id, fname, lname, email, province, contact, address_1, address_2, postal_code) VALUES ('{$user_id}', '{$billing_id}', '{$fname}', '{$lname}', '{$email}', '{$province}', '{$contact}', '{$address1}', '{$address2}', '{$zipcode}')");
        if ($billing_query) {
            $_SESSION['success'] = "Successfully Saved";
        } else {
            $_SESSION['error'] = "Failed to save";
        }
    }

    public function saveBilling($user_id, $billing_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $additional_address, $zipcode)
    {
        $this->conn->query("INSERT INTO {$this->tbl_name}(user_id, billing_id, fname, lname, email, province, contact, address_1, address_2, additional_address, postal_code) VALUES ('{$user_id}', '{$billing_id}', '{$fname}', '{$lname}', '{$email}', '{$province}', '{$contact}', '{$address1}', '{$address2}', '{$additional_address}', '{$zipcode}')");
    }

    public function getBillingInfo($billing_id)
    {
        $res = $this->conn->query("SELECT * FROM {$this->tbl_name} WHERE billing_id = '{$billing_id}' LIMIT 1");
        if ($res->num_rows > 0) {
            $result = $res->fetch_assoc();
        } else {
            $result = "Not Found";
        }

        return $result;
    }
    public function costumerBilling($user_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $additional_address, $postal_code, $billing_id)
    {
        $this->conn->query("UPDATE {$this->tbl_name} SET user_id = '{$user_id}', fname = '{$fname}', lname = '{$lname}', email = '{$email}', province = '{$province}', contact = '{$contact}', address_1 = '{$address1}', address_2 = '{$address2}', additional_address = '{$additional_address}', postal_code = '{$postal_code}' WHERE billing_id = '{$billing_id}' LIMIT 1");
    }

    
    public function updateBilling($user_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $additional_address, $postal_code, $billing_id)
    {
        $billing_query = $this->conn->query("UPDATE {$this->tbl_name} SET user_id = '{$user_id}', fname = '{$fname}', lname = '{$lname}', email = '{$email}', province = '{$province}', contact = '{$contact}', address_1 = '{$address1}', address_2 = '{$address2}', additional_address = '{$additional_address}', postal_code = '{$postal_code}' WHERE billing_id = '{$billing_id}' LIMIT 1");
        if ($billing_query) {
            $_SESSION['success'] = "Updated Successfully";
        } else {
            $_SESSION['error'] = "Failed to save";
        }
    }

    public function deleteBilling($billing_id)
    {
        $this->conn->query("DELETE FROM {$this->tbl_name} WHERE billing_id = '{$billing_id}' LIMIT 1");
    }
}

$billing = new Billings($conn);
?>