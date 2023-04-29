<?php
class Category {
    private $conn;
    public $tbl_name = "tbl_category";

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

    public function totalCategory(){
        $category_query = $this->conn->query("SELECT * FROM {$this->tbl_name}");
        $total = mysqli_num_rows($category_query);
        return $total;
    }

    public function addCategory($cid, $name){
        $category_query = $this->conn->query("INSERT INTO {$this->tbl_name}(category_id, category_name) VALUES ('{$cid}', '{$name}')");
        if($category_query){
            $_SESSION['success'] = "Successfully Saved";
        }else{
            $_SESSION['error'] = "Failed to save";
        }
    }

    public function updateCategory($cid, $name){
        $sql = "UPDATE {$this->tbl_name} SET category_name = ? WHERE category_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $name, $cid);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Updated Successfully";
        } else {
            $_SESSION['error'] = "Failed to Update";
        }
    }

    public function deleteCategory($cid){
       $this->conn->query("DELETE FROM {$this->tbl_name} WHERE category_id = '{$cid}' LIMIT 1");
    }
}

$category = new Category($conn);
?>