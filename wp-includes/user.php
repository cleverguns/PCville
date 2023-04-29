<?php
class Users
{
    private $conn;
    public $tbl_name = "tbl_users";

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

    public function addUser($uid, $fname, $lname, $avatar, $username, $email, $password, $user_role, $status)
    {
        if (!empty($status)) {
            $stmt = $this->conn->prepare("INSERT INTO {$this->tbl_name} (user_id, fname, lname, avatar, username, email, password, user_role, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $uid, $fname, $lname, $avatar, $username, $email, $password, $user_role, $status);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO {$this->tbl_name} (user_id, fname, lname, avatar, username, email, password, user_role, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $uid, $fname, $lname, $avatar, $username, $email, $password, $user_role, 'not-verified');
        }
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Successfully Registered";
        } else {
            $_SESSION['error'] = "Failed Saved";
        }
    }

    public function deleteUser($uid)
    {
        $this->conn->query("DELETE FROM {$this->tbl_name} WHERE user_id = '{$uid}' LIMIT 1");
    }

    public function editPhoto($uid, $name)
    {
        $res =  $this->conn->query("UPDATE {$this->tbl_name} SET avatar = '{$name}' WHERE user_id = '{$uid}' LIMIT 1");
        if ($res) {
            $_SESSION['success'] = "Successfully Saved";
        } else {
            $_SESSION['error'] = "Failed Saved";
        }
    }

    public function updateUserInfo($uid, $fname, $lname, $email, $password, $user_role)
    {
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if (!empty($user_role)) {
                $stmt = $this->conn->prepare("UPDATE {$this->tbl_name} SET fname = ?, lname = ?, email = ?, password = ?, user_role = ? WHERE user_id = ? LIMIT 1");
                $stmt->bind_param("ssssss", $fname, $lname, $email, $password_hash, $user_role, $uid);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $_SESSION['success'] = "Updated Successfully";
                } else {
                    $_SESSION['error'] = "Failed Update";
                }
            } else {
                $stmt = $this->conn->prepare("UPDATE {$this->tbl_name} SET fname = ?, lname = ?, email = ?, password = ? WHERE user_id = ? LIMIT 1");
                $stmt->bind_param("sssss", $fname, $lname, $email, $password_hash, $uid);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $_SESSION['success'] = "Updated Successfully";
                } else {
                    $_SESSION['error'] = "Failed Update";
                }
            }
        } else {
            if (!empty($user_role)) {
                $stmt = $this->conn->prepare("UPDATE {$this->tbl_name} SET fname = ?, lname = ?, email = ?, user_role = ? WHERE user_id = ? LIMIT 1");
                $stmt->bind_param("sssss", $fname, $lname, $email, $user_role, $uid);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $_SESSION['success'] = "Updated Successfully";
                } else {
                    $_SESSION['error'] = "Failed Update";
                }
            } else {
                $stmt = $this->conn->prepare("UPDATE {$this->tbl_name} SET fname = ?, lname = ?, email = ? WHERE user_id = ? LIMIT 1");
                $stmt->bind_param("ssss", $fname, $lname, $email, $uid);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $_SESSION['success'] = "Updated Successfully";
                } else {
                    $_SESSION['error'] = "Failed Update";
                }
            }
        }
    }

    public function getUserInfo($uid)
    {
        $res = $this->conn->query("SELECT fname, lname, email, user_role FROM {$this->tbl_name} WHERE user_id = '{$uid}' LIMIT 1");
        if ($res->num_rows > 0) {
            $result = $res->fetch_assoc();
        } else {
            $result = "User Id Not Found";
        }
        return $result;
    }

    public function totalUsers()
    {
        $users_query = $this->conn->query("SELECT * FROM {$this->tbl_name}");
        $total = mysqli_num_rows($users_query);
        return $total;
    }
}

$user = new Users($conn);
