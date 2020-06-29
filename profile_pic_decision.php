<?php

    $img_status = $member['img_upload_status'];

    if($img_status == 1){
        echo("Uploads_Profile_Pics/".$username.".jpg");
    }
    else{
        echo("Uploads_Profile_Pics\person.jpg");
    }

?>