
<?php
        
session_start();
include_once('lib/database.php');
$username = $_SESSION["username"];

//Getting member details
$member = mysqli_query($conn,"SELECT * FROM tbl_member where username='".$username."'");
$member = mysqli_fetch_array($member);

        if (isset($_POST['submit_info'])) {
            $about = $_POST["about"];
            $job = $_POST["job"];
            $company = $_POST["company"];
            $facebook = $_POST["facebook"];
            $twitter = $_POST["twitter"];
            $linkedin = $_POST["linkedin"];
            $email = $_POST["email"];
            $id = $member['id'];
        
            echo $email.'<br>';
            echo $id.'<br>';
            echo $about.'<br>';
            echo $job.'<br>';
            echo $company.'<br>';
            echo $facebook.'<br>';
            echo $twitter.'<br>';
            echo $linkedin.'<br>';
    
            $sql = "UPDATE tbl_member SET Profile_Description= '$about' WHERE id=$id";
            $conn->query($sql);

            $sql = "UPDATE tbl_member SET Job_Profile= '$job' WHERE id=$id";
            $conn->query($sql);

            $sql = "UPDATE tbl_member SET Company = '$company' WHERE id=$id";
            $conn->query($sql);
    
            $sql = "UPDATE tbl_member SET email = '$email' WHERE id=$id";
            $conn->query($sql);
    
            $sql = "UPDATE tbl_member SET Facebook= '$facebook' WHERE id=$id";
            $conn->query($sql);
    
            $sql = "UPDATE tbl_member SET Twitter= '$twitter' WHERE id=$id";
            $conn->query($sql);
    
            $sql = "UPDATE tbl_member SET Linkedin= '$linkedin' WHERE id=$id";
            $conn->query($sql);}

    $conn->commit();
    $member = mysqli_query($conn,"SELECT * FROM tbl_member where username='".$username."'");
    $member = mysqli_fetch_array($member);

    header("Location: Profile_Page.php");
    ?>