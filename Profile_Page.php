<?php
session_start();
include_once('lib/database.php');
$username = $_SESSION["username"];

//Getting member details
$member = mysqli_query($conn,"SELECT * FROM tbl_member where username='".$username."'");
$member = mysqli_fetch_array($member);
?>
<HTML>
<HEAD>
<TITLE>Incubator</TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo BASE_URL ?>/assets/css/profile_style.css" type="text/css"rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"/>


</HEAD>
<BODY>
    <div style="display:none">
        <div id="member-id">
            <?php echo $member['id'] ?>
        </div>
    </div>

    <?php include('assets/elements/header.php') ?>
	<div class="container">
        <!--profile pic and name-->
        <div class = "profile_container">
            <div class = "profile_pic" onmouseover="profile_hover()" onmouseout="profile_hover_fin()" >
                <img src="<?php include('profile_pic_decision.php') ?>" id= "pimg">
                <div class = "img-btn"><i class="fa fa-pencil fa-lg" id="profile_pic_add" style="display:none;" onclick="openModal2()"></i></div>
            </div>
            <div class = "personal_info">
                <span class="fname"><?php echo($member['firstname'])?></span><span class="lname"><?php echo($member['lastname'])?></span><br>
                <span class = "email"><?php echo($member['email'])?></span>
                <div class="social-menu">
                    <ul>
                        <li><a href="<?php echo($member['Facebook'])?>" target = "_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="<?php echo($member['Twitter'])?>" target = "_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="<?php echo($member['Linkedin'])?>" target = "_blank"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- random details-->
        <div class = "content_rest">
            <div class = "nav">
                <div class="edit-button"  onclick="openModal()"><i class="fa fa-pencil"></i></div>
            </div>
            <div class = "dashboard">
                <div class="desc"><p><?php echo($member['Profile_Description'])?></p>
                </div>
            </div>
            <div class = "Job_Profile"><div class="filler"><span class="dtitle">Job Profile: </span><span class="dtext"><?php echo($member['Job_Profile'])?></span></div></div>
            <div class = "Company"><div class="filler"><span class="dtitle">Company: </span><span class="dtext"><?php echo($member['Company'])?></span></div></div>
        </div>
        <div class = "footer"></div>
        
    </div>

<!-- ..............................modal for detail updates.............................................-->
<div id="myModal" class="modal" onclick="console.log('outsideclick')">
  <span id="closeModal" class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content-details">
    <div class= "form-block">
        <form method="post" action="<?php echo htmlspecialchars(BASE_URL.'/Profile_Page_Info_Update.php');?>">
            <h1> Update Profile Info.</h1><br>
            <label>Personal Description. </label>
            <textarea rows = "6" name="about"><?php echo($member['Profile_Description'])?></textarea><br>
            <div>
                <div class = "lbl">
                    <label>Job Profile</label>
                </div>
            <input type="text" value="<?php echo($member['Job_Profile'])?>" name="job"><br>
            </div>
            <div>
                <div class = "lbl">
                    <label>Company</label>
                </div>
            <input type = "text" value="<?php echo($member['Company'])?>" name="company"><br>
            </div>
            <div>
                <div class = "lbl">
                    <label>Email</label>
                </div>
            <input type = "text" value="<?php echo($member['email'])?>" name="email"><br>
            </div>
            <div>
                <div class = "lbl">
                    <label>Facebook</label>
                </div>
            <input type = "text" value="<?php echo($member['Facebook'])?>" name="facebook"><br>
            </div>
            <div>
                <div class = "lbl">
                    <label>Twitter</label>
                </div>
            <input type = "text" value="<?php echo($member['Twitter'])?>" name="twitter"><br>
            </div>
            <div>
                <div class = "lbl">
                    <label>Linkedin</label>
                </div>
            <input type = "text" value="<?php echo($member['Linkedin'])?>" name="linkedin"><br>
            </div>
            <div>
            <input type = "submit" class = "submit-btn" value="Update" name="submit_info">
            </div>
        </form>
    </div>
  </div>
</div>
<!--.....................................modal for profile pic update.........................................-->
<div id="myModal2" class="modal2" onclick="console.log('outsideclick')">
    <span id="closeModal2" class="close cursor" onclick="closeModal2()">&times;</span>
    <div class="modal-content-pic">
        <div class = "profile_pic_modal" onmouseover="profile_hover_modal()" onmouseout="profile_hover_fin_modal()">
            <img src="<?php include('profile_pic_decision.php') ?>" id= "output_image">
            <div class = "img-btn-modal" id="delete_img">
                <form  method="post" action="<?php echo htmlspecialchars(BASE_URL.'/profile_pic_delete.php');?>">
                    <button class = "delete-btn" type="submit" name="delete_pic">&times;</button>
                </form>
            </div>
        </div>
        <form action="prof_upload.php" method="post" enctype="multipart/form-data"> 
            <div class="pic_update_btn" onclick="document.getElementById('getFile').click()">Choose a pic</div>
            <input type='file' name="file" id="getFile" style="display:none" onchange="preview_image(event)">
            <button class="pic_update_btn" type="submit" name="submit">UPDATE</button>
        </form>
  </div>
</div>
<!--...........................................end of modals................................................................-->

    <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/vendor/jquery/jquery-3.3.1.js"></script>
    
    <script type="text/javascript">
        function profile_hover(){
            var pimg = document.getElementById("pimg");
            pimg.style.filter = "blur(10px)";
            var plus = document.getElementById("profile_pic_add");
            plus.style.display = "inline-block";

        }

        function profile_hover_fin(){
            var pimg = document.getElementById("pimg");
            pimg.style.filter = "blur(0px)";
            var plus = document.getElementById("profile_pic_add");
            plus.style.display = "none";
        }

        function profile_hover_modal(){
            var pimg = document.getElementById("output_image");
            pimg.style.filter = "blur(10px)";
            var plus = document.getElementById("delete_img");
            plus.style.display = "inline-block";

        }

        function profile_hover_fin_modal(){
            var pimg = document.getElementById("output_image");
            pimg.style.filter = "blur(0px)";
            var plus = document.getElementById("delete_img");
            plus.style.display = "none";

        }

        function preview_image(event){
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function openModal2() {
            document.getElementById("myModal2").style.display = "block";
        }


        function closeModal2() {
            document.getElementById("myModal2").style.display = "none";
        }
    </script>
    

</BODY>
</HTML>