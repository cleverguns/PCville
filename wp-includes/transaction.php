<?php

class Transaction {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
        
    }

    public function add_transaction($uid, $transaction_id, $type, $amount, $description, $status){
        $date = date("Y-m-d");
        $transaction_query = $this->conn->query("INSERT INTO tbl_transactions(user_id, transaction_id, type, amount, description, status, date_created) VALUES ('{$uid}', '{$transaction_id}', '{$type}', '{$amount}', '{$description}', '{$status}', '{$date}')");

        if($transaction_query){
            $result = "success";
        } else {
            $result = "failed";
        }

        return $result;
    }

    public function update_transaction($uid, $transaction_id, $status){
        $transaction_query = $this->conn->query("UPDATE tbl_transactions SET status = '{$status}' WHERE transaction_id = '{$transaction_id}' AND user_id = '{$uid}' LIMIT 1");

        if($transaction_query){
            $result = "success";
        } else {
            $result = "failed";
        }

        return $result;
    }
}

$transaction = new Transaction($conn);

?>