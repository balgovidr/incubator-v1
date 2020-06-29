<?php
session_start();
include_once('lib/database.php');
if (empty($_SESSION["username"])) {
    header("Location:".BASE_URL);
}
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
            <?php echo $MemberId ?>
        </div>
    </div>
	<div class="container">
        <!-- Fetches the header and displays it -->
        <?php include('assets/elements/header.php') ?>
        <!-- Shows notification if you haven't confirmed your email -->
        <div class="notification" id="notification1" style="display:<?php if ($member['email_confirm']!='Confirmed') { echo 'flex'; } else { echo 'none';}; ?>">
            <span>
                Please follow the link in your email to confirm it, or click
                <!-- On click executes javascript function to sent confirmation email, then changes the text within to Sent!, then closes the notification after a 2sec delay -->
                <a class="link" onclick="ConfirmEmail('<?php echo $username ?>'); document.getElementById('notification1').innerHTML='Sent!'; setTimeout(function() {ToggleDisplay('notification1','flex')}, 2000)">here</a>&nbsp;to get a new link.
            </span>
            <!-- Icon to close the notification -->
            <div class="right icon link">
                <i class="fas fa-times" onclick="ToggleDisplay('notification1','flex')"></i>
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
$ideas = mysqli_query($conn,"SELECT * FROM tbl_ideas where member_id='".$MemberId."'");
            
            while ($row = mysqli_fetch_array($ideas)) { ?>
        <div class="rows">
            <!-- Onclick of each row of ideas opens the lightbox that contains details of the idea.-->
            <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $MemberId ?>)" class="link adjust-size">
                <?php echo $row['title'] ?>
            </a>
            <!-- Alternative button to open the lightbox and edit -->
            <a class="fixed-size icon" onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $MemberId ?>)">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        <?php } ?>
            <br/>
            <br/>
            <div class="title hidden" id="ideas-shared-with-you">Ideas shared with you</div>
            <?php
            
//Getting ideas, ones shared with you as friend
$ideas = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE share_friends LIKE '%#".$MemberId."#%'");
            
        while ($row = mysqli_fetch_array($ideas)) {
            //Turns the $DisplayTitle to 1 if the 'Ideas shared with you title' is to be showed
            $DisplayTitle=1; ?>
            <div class="rows" id="row-<?php echo $row['id'] ?>">
                <!-- Onclick of each row opens up the lightbox containing more information about the idea -->
                <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $MemberId ?>)" class="adjust-size link">
                    <?php echo $row['title'] ?>
                </a>
                <!-- Count of votes for an idea -->
                <div class="fixed-size">
                    <?php 
                        if($row['votes']!='') {
                            //Counts the number of # and divides by 2
                            $VoteCount = substr_count($row['votes'],'#')/2;
                            echo $VoteCount;
                            if ($VoteCount>1) {
                                echo ' votes';
                            } else {
                                echo ' vote';
                            };
                        };
                    ?>
                    &nbsp;
                </div>
                <!-- Onclick adds member ID and vote type (public or anonymous) to the idea database -->
                <a class="fixed-size icon" onclick="VoteIdea(<?php echo $row['id'] ?>,'public')" style="color:<?php 
                //Checks if the user has already voted it and displays the voted colour
                if (strpos($row['votes'],'#'.$MemberId.',')!==FALSE) { echo '#4db6ac'; } ?>">
                    <i class="fas fa-heart"></i>
                </a>
                &nbsp;&nbsp;
                <!-- Alternative button to open the lightbox and edit -->
                <a class="fixed-size icon" onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $MemberId ?>)">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        <?php }

        
//Getting ideas, ones shared with you in a group
$user_groups = mysqli_query($conn,"SELECT * FROM tbl_group WHERE members LIKE '%#".$MemberId."#%'");

            while ($user_group = mysqli_fetch_array($user_groups)) {
                $ideas = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE share_groups LIKE '%#".$user_group['id']."#%'");
                
                while ($row = mysqli_fetch_array($ideas)) {
                    //Turns the $DisplayTitle to 1 if the 'Ideas shared with you title' is to be showed
                    $DisplayTitle=1; ?>
        <div class="rows" id="row-<?php echo $row['id'] ?>">
            <a onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $MemberId ?>)" class="adjust-size link">
                <?php echo $row['title'] ?>
            </a>
            <!-- Count of votes for an idea -->
            <div class="fixed-size">
                <?php 
                    if($row['votes']!='') {
                        //Counts the number of # and divides by 2
                        $VoteCount = substr_count($row['votes'],'#')/2;
                        echo $VoteCount;
                        if ($VoteCount>1) {
                            echo ' votes';
                        } else {
                            echo ' vote';
                        };
                    };
                ?>
                &nbsp;
            </div>
            <!-- Onclick adds member ID and vote type (public or anonymous) to the idea database -->
            <a class="fixed-size icon" onclick="VoteIdea(<?php echo $row['id'] ?>,'public')" style="color:<?php 
            //Checks if the user has already voted it and displays the voted colour
            if (strpos($row['votes'],'#'.$MemberId.',')!==FALSE) { echo '#4db6ac'; } ?>">
                <i class="fas fa-heart"></i>
            </a>
            &nbsp;&nbsp;
            <!-- Alternative button to open the lightbox and edit -->
            <a class="fixed-size icon" onclick="openModal();currentSlide(<?php echo $row['id'] ?>,'idea',<?php echo $MemberId ?>)">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        <?php };};  
        ?>
        </div>
    </div>
    </div>
    
    <!-- The Modal/Lightbox -->
<div id="myModal" class="modal">
  <span id="closeModal" class="close cursor">&times;</span>
  <div class="modal-content">
          <!-- Contents are within the idea_description.php file -->
  </div>
</div>
    
    
    <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/vendor/jquery/jquery-3.3.1.js"></script>
    <?php
        //Checks if the title 'Ideas shared with you' is to be shown, toggles the display if it should
        if ($DisplayTitle==1) {
            echo "<script type='text/javascript'>ToggleDisplay2('ideas-shared-with-you','flex');</script>";
        };
    ?>
    
    <!-- Main Quill library -->
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

</BODY>
</HTML>