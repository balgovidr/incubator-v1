<?php 

    session_start();

    include_once('lib/database.php');


    $username = $_SESSION["username"];



    if(isset($_POST['submit'])){

        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name']; 
        $fileSize = $_FILES['file']['size']; 
        $fileError = $_FILES['file']['error']; 
        $fileType = $_FILES['file']['type'];  

        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg','jpeg','png');

        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize <= 1000000){

                    $sql = "UPDATE tbl_member SET img_upload_status= 1 WHERE username = '$username' ";
                    $conn->query($sql);
                    $conn->commit();

                    $fileNameNew = $username.".".$fileActualExt;
                    $fileDestination = "Uploads_Profile_pics/".$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    header("Location: Profile_page.php?uploadsuccess");
                }else{
                    echo "File is too big";
                }
            }
            else{
                echo "There was an error uploading your file";
            }
        }
        else{
            // echo "You cannot upload files of this type";
            header("Location: Profile_page.php?");
        }
    }

?>