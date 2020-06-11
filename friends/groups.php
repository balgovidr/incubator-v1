<?php
session_start();
include_once('../lib/database.php');
$username = $_SESSION["username"];

//Getting member details
$member = mysqli_query($conn,"select * FROM tbl_member where username='".$username."'");
$member = mysqli_fetch_array($member);
?>
<HTML>
<HEAD>
<TITLE>Groups | Incubator</TITLE>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link href="<?php echo BASE_URL ?>/assets/css/style.css" type="text/css"
	rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"/>
</HEAD>
<BODY>
	<div class="container">
        <?php include('../assets/elements/header.php') ?>
        <div class="content">
        <?php include('../assets/elements/menu.php') ?>
            <div class="content-rows">
        <div class="rows">
            <div id="clickbox" contenteditable="true" data-placeholder="Create a new group here..." class="adjust-size"></div>
            <a class="icon fixed-size" onclick="appendgroup()">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <?php
            
//Getting groups
$groups = mysqli_query($conn,"select * FROM tbl_group where member_id='".$member['id']."'");
            
            while ($row = mysqli_fetch_array($groups)) { ?>
        <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'group',<?php echo $member['id'] ?>)" class="rows link">
            <?php echo $row['title'] ?>
        </a>
        <?php } ?>
        </div>
    </div>
    </div>
    
    <!-- The Modal/Lightbox -->
<div id="myModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">
          <!-- Contents are within the group_description.php file -->
  </div>
</div>
    
    <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/vendor/jquery/jquery-3.3.1.js"></script>

</BODY>
</HTML>