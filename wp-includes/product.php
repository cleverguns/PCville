<?php
class Products
{
    private $conn;
    public $tbl_name = "tbl_products";
    
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

    public function addProduct($product_id, $category_id, $product_photo, $name, $description, $prize, $stock, $shipping)
    {
        $sql = "INSERT INTO {$this->tbl_name} (product_id, category_id, product_photo, name, description, prize, stock, shipping) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssiii", $product_id, $category_id, $product_photo, $name, $description, $prize, $stock, $shipping);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Successfully Saved";
        } else {
            $_SESSION['error'] = "Failed to save";
        }
       
    }

    public function updateProduct($product_id, $category_id, $name, $description, $prize, $stock, $shipping)
    {
        $sql = "UPDATE {$this->tbl_name} SET category_id = ?, name = ?, description = ?, prize = ?, stock = ?, shipping= ? WHERE product_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssiiis", $category_id, $name, $description, $prize, $stock, $shipping, $product_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Updated Successfully";
        } else {
            $_SESSION['error'] = "Failed to Update";
        }
    }

    public function editPhoto($pid, $name)
    {
        $res =  $this->conn->query("UPDATE {$this->tbl_name} SET product_photo = '{$name}' WHERE product_id = '{$pid}' LIMIT 1");
        if ($res) {
            $_SESSION['success'] = "Updated Successfully";
        } else {
            $_SESSION['error'] = "Failed to Update";
        }
    }

    public function getProductInfo($pid){
        $res = $this->conn->query("SELECT p.name, p.description, p.prize, p.stock, p.shipping, c.category_id as category FROM tbl_products p LEFT JOIN tbl_category c ON p.category_id = c.category_id WHERE p.product_id = '{$pid}' LIMIT 1");
        if($res->num_rows > 0){
            $result = $res->fetch_assoc();
        }else{
            $result = "Not Found";
        }

        return $result;
    }

    public function deleteProduct($product_id)
    {
        $sql = "DELETE FROM {$this->tbl_name} WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $product_id);
        $stmt->execute();
        $stmt->close();
    }

    public function totalProducts(){
        $query = "SELECT * FROM {$this->tbl_name}";
        $products =  $this->conn->query($query);
        $total = mysqli_num_rows($products);
        return $total;
    }
}

$products = new Products($conn);
