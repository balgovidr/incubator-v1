<?php
session_start();
include_once('lib/database.php');
$username = $_SESSION["username"];
$MemberId = $_SESSION["MemberId"];

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
<!--Required for the montserrat font -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"/>
</HEAD>
<BODY>
    <!-- Sets the member's id so that it can be used later by some javascript functions-->
    <div style="display:none">
        <div id="member-id">
            <?php echo $member['id'] ?>
        </div>
    </div>
	<div class="container">
        <!-- Fetches the header and displays it -->
        <?php include('assets/elements/header.php') ?>
        <!-- Shows notification if you haven't confirmed your email -->
        <div class="notification" id="notification1" style="display:<?php if ($member['email_confirm']!='Confirmed') { echo 'flex'; } else { echo 'none';}; ?>">
            Please follow the link in your email to confirm it, or click&nbsp;
            <!-- On click executes javascript function to sent confirmation email, then changes the text within to Sent!, then closes the notification after a 2sec delay -->
            <a class="link" onclick="ConfirmEmail('<?php echo $username ?>'); document.getElementById('notification1').innerHTML='Sent!'; setTimeout(function() {ToggleDisplay('notification1')}, 2000)">here</a>&nbsp;to get a new link.
            <!-- Icon to close the notification -->
            <div class="right icon link">
                <i class="fas fa-times" onclick="ToggleDisplay('notification1')"></i>
            </div>
        </div>

        <div class="content">
        <!-- Shows the menu element -->
        <?php include('assets/elements/menu.php') ?>
        <div class="content-rows">
            <div class="title">Your ideas</div>
        <div class="rows">
            <!-- Div to type ideas into -->
            <div id="clickbox" class="adjust-size" contenteditable="true" data-placeholder="Add your new idea here..."></div>
            <!-- Button to add the text in the div above into the database -->
            <a class="icon fixed-size" onclick="appendidea()">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <?php
            
//Getting ideas
$ideas = mysqli_query($conn,"SELECT * FROM tbl_ideas where member_id='".$member['id']."'");
            
            while ($row = mysqli_fetch_array($ideas)) { ?>
        <div class="rows">
            <!-- Onclick of each row of ideas opens the lightbox that contains details of the idea.-->
            <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $member['id'] ?>)" class="link adjust-size">
                <?php echo $row['title'] ?>
            </a>
            <!-- Delete button for idea, only for ideas that you created -->
            <a class="fixed-size icon" onclick="deleteidea(<?php echo $row['id'] ?>)">
                <i class="fas fa-trash"></i>
            </a>
        </div>
        <?php } ?>
            <br/>
            <br/>
            <div class="title">Ideas shared with you</div>
            <?php
            
//Getting ideas, ones shared with you as friend
$ideas = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE share_friends LIKE '%#".$member['id']."#%'");
            
        while ($row = mysqli_fetch_array($ideas)) { ?>
            <div class="rows" id="row-<?php echo $row['id'] ?>">
                <!-- Onclick of each row opens up the lightbox containing more information about the idea -->
                <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $member['id'] ?>)" class="adjust-size link">
                    <?php echo $row['title'] ?>
                </a>
                <!-- Count of votes for an idea -->
                <div class="fixed-size">
                    <?php 
                        if($row['votes']!='') {
                            //Counts the number of # and divides by 2
                            echo substr_count($row['votes'],'#')/2;
                        };
                    ?>
                </div>
                <!-- Onclick adds member ID and vote type (public or anonymous) to the idea database -->
                <a class="fixed-size icon" onclick="VoteIdea(<?php echo $row['id'] ?>,'public')">
                    <i class="fas fa-heart"></i>
                </a>
            </div>
        <?php }
//Getting ideas, ones shared with you in a group
$user_groups = mysqli_query($conn,"SELECT * FROM tbl_group WHERE members LIKE '%#".$member['id']."#%'");

            while ($user_group = mysqli_fetch_array($user_groups)) {
                $ideas = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE share_groups LIKE '%#".$user_group['id']."#%'");
                
                while ($row = mysqli_fetch_array($ideas)) { ?>
        <div class="rows" id="row-<?php echo $row['id'] ?>">
            <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $member['id'] ?>)" class="adjust-size link">
                <?php echo $row['title'] ?>
            </a>
            <!-- Count of votes for an idea -->
            <div class="fixed-size">
                <?php 
                    if($row['votes']!='') {
                        //Counts the number of # and divides by 2
                        echo substr_count($row['votes'],'#')/2;
                    };
                ?>
            </div>
            <!-- Onclick adds member ID and vote type (public or anonymous) to the idea database -->
            <a class="fixed-size icon" onclick="VoteIdea(<?php echo $row['id'] ?>,'public')" style="color:<?php if (strpos($row['votes'],'#'.$MemberId.',')!==FALSE) { echo '#4db6ac'; } ?>">
                <i class="fas fa-heart"></i>
            </a>
        </div>
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