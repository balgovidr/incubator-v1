<?php
namespace Phppot;

class Member
{

    private $ds;

    function __construct()
    {
        require_once __DIR__ . './../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    public function isMemberExists($email,$username)
    {   
        $value=0;
        $query = 'SELECT * FROM tbl_member where username = ?';
        $paramType = 's';
        $paramValue = array(
            $username
        );
        $insertRecord = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($insertRecord)) {
            $count = count($insertRecord);
        }
        if ($count > 0) {
            $value=-1;
        }

        $query2 = 'SELECT * FROM tbl_member where email = ?';
        $paramType2 = 's';
        $paramValue2 = array(
            $email
        );
        $insertRecord2 = $this->ds->select($query2, $paramType2, $paramValue2);
        $count = 0;
        if (is_array($insertRecord2)) {
            $count = count($insertRecord2);
        }
        if ($count > 0) {
            $value=1;
        }
        return $value;
    }

    public function registerMember()
    {
        $result = $this->isMemberExists($_POST["email"],$_POST["signup-username"]);
        if ($result == 0) {
            if (! empty($_POST["signup-password"])) {
                $hashedPassword = password_hash($_POST["signup-password"], PASSWORD_DEFAULT);
            }
            $query = 'INSERT INTO tbl_member (username, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)';
            $paramType = 'sssss';
            $paramValue = array(
                $_POST["signup-username"],
                $hashedPassword,
                $_POST["email"],
                $_POST["firstname"],
                $_POST["lastname"]
            );
            $memberId = $this->ds->insert($query, $paramType, $paramValue);
            if(!empty($memberId)) {
                $response = array("status" => "success", "message" => "You have registered successfully.", "username" => $_POST["signup-username"]);
            }
        } else if ($result == 1) {
            $response = array("status" => "error", "message" => "Email already exists.");
        } else if ($result == -1) {
            $response = array("status" => "error", "message" => "Username already exists.");
        }
        return $response;
    }

    public function getMember($username)
    {
        $query = 'SELECT * FROM tbl_member where username = ?';
        $paramType = 's';
        $paramValue = array(
            $username
        );
        $loginUser = $this->ds->select($query, $paramType, $paramValue);
        return $loginUser;
    }

    public function loginMember()
    {
        $loginUserResult = $this->getMember($_POST["signin-username"]);
        if (! empty($_POST["signin-password"])) {
            $password = $_POST["signin-password"];
        }
        $hashedPassword = $loginUserResult[0]["password"];
        $loginPassword = 0;
        if (password_verify($password, $hashedPassword)) {
            $loginPassword = 1;
        }
        if ($loginPassword == 1) {
            $_SESSION["username"] = $loginUserResult[0]["username"];
            $_SESSION["MemberId"] = $loginUserResult[0]["id"];
            $url = "./home.php";
            header("Location: $url");
        } else if ($loginPassword == 0) {
            $loginStatus = "Invalid username or password.";
            return $loginStatus;
        }
    }
}
