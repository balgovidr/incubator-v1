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
<link href="<?php echo BASE_URL ?>/assets/css/style.css" type="text/css"
	rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"/>
</HEAD>
<BODY>
    <div style="display:none">
        <div id="member-id">
            <?php echo $member['id'] ?>
        </div>
    </div>
	<div class="container">
        <?php include('assets/elements/header.php') ?>
        <div class="content">
        <?php include('assets/elements/menu.php') ?>
        <div class="content-rows">
            <div class="title">Your ideas</div>
        <div class="rows">
            <div id="clickbox" class="adjust-size" contenteditable="true" data-placeholder="Add your new idea here..."></div>
            <a class="icon fixed-size" onclick="appendidea()">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <?php
            
//Getting ideas
$ideas = mysqli_query($conn,"SELECT * FROM tbl_ideas where member_id='".$member['id']."'");
            
            while ($row = mysqli_fetch_array($ideas)) { ?>
        <div class="rows">
            <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $member['id'] ?>)" class="link adjust-size">
                <?php echo $row['title'] ?>
            </a>
            <a class="fixed-size icon" onclick="deleteidea(<?php echo $row['id'] ?>)">
                <i class="fas fa-trash"></i>
            </a>
        </div>
        <?php } ?>
            <br/>
            <br/>
            <div class="title">Ideas shared with you</div>
            <?php
            
//Getting ideas
$ideas = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE share_friends LIKE '%#".$member['id']."#%'");
            
        while ($row = mysqli_fetch_array($ideas)) { ?>
            <div class="rows">
                <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $member['id'] ?>)" class="adjust-size link">
                    <?php echo $row['title'] ?>
                </a>
                <div class="fixed-size" id="vote-count<?php echo $row['id'] ?>">
                    <?php 
                        if($row['votes']!='') {
                            $vote_array=json_decode($row['votes']);
                            echo count($vote_array);
                        };
                    ?>
                </div>
                <a class="fixed-size icon" onclick="VoteIdea(<?php echo $row['id'] ?>,<?php echo $member['id'] ?>,'public')">
                    <i class="fas fa-heart"></i>
                </a>
            </div>
        <?php }
            
$user_groups = mysqli_query($conn,"SELECT * FROM tbl_group WHERE members LIKE '%#".$member['id']."#%'");

            while ($user_group = mysqli_fetch_array($user_groups)) {
                $ideas = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE share_groups LIKE '%#".$user_group['id']."#%'");
                
                while ($row = mysqli_fetch_array($ideas)) { ?>
        <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $member['id'] ?>)" class="rows link">
            <?php echo $row['title'] ?>
        </a>
        <?php };};  ?>
        </div>
    </div>
    </div>
    
    <!-- The Modal/Lightbox -->
<div id="myModal" class="modal" onclick="console.log('outsideclick')">
  <span id="closeModal" class="close cursor">&times;</span>
  <div class="modal-content">
          <!-- Contents are within the idea_description.php file -->
  </div>
</div>
    
    
    <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/vendor/jquery/jquery-3.3.1.js"></script>
    
    <!-- Main Quill library -->
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

</BODY>
</HTML>