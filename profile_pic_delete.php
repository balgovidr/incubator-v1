<?php
        
session_start();
include_once('lib/database.php');
$username = $_SESSION["username"];

//Getting member details
$member = mysqli_query($conn,"SELECT * FROM tbl_member where username='".$username."'");
$member = mysqli_fetch_array($member);

        if (isset($_POST['delete_pic'])){

    
            $sql = "UPDATE tbl_member SET img_upload_status= 0 WHERE username = '$username' ";
            $conn->query($sql);
            $conn->commit();

        }

        
    header("Location: Profile_Page.php?deletesuccessful");
    ?>