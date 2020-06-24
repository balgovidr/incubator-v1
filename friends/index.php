<?php
session_start();
include_once('../lib/database.php');
$username = $_SESSION["username"];

//Getting member details
$member = mysqli_query($conn,"select * FROM tbl_member where username='".$username."'");
$member = mysqli_fetch_array($member);

//Collecting search results
$output='';
if (isset($_POST['search'])) {
    $searchq=$_POST['search'];
    $query=mysqli_query("SELECT * FROM tbl_members WHERE firstname LIKE '%$searchq%' OR lastname LIKE '%$searchq%'") or die("could not search!");
    if($requests->num_rows===0) {
        $output='There was no search results!';
    }else{
        while ($row = mysql_fetch_array($query)) {
            
        }
    };
}
?>
<HTML>
<HEAD>
    <TITLE>Friends | Incubator</TITLE>
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
            <div class="dropdown">
                <form action="<?php echo BASE_URL ?>/friends/search.php" method="post" class="search-container">
                <input type="text" class="bar adjust-size" id="members-input" onfocus="dropdown('members-dropdown')" onfocusout="dropdown('members-dropdown')" onkeyup="filterFunction('members-dropdown','members-input')" autocomplete="off" name="search" placeholder="Search for members..."/>
                <input type="submit" value="Search" class="button fixed-size"/>
                </form>

                <div id="members-dropdown" class="dropdown-content search-filter">
                    <?php
                    $allmembers = mysqli_query($conn,"SELECT id, username, firstname, lastname FROM tbl_member");
                        while ($allmember = mysqli_fetch_array($allmembers)) {
                            if ($allmember['id']!==$member['id']) {
                    ?>
                    <a style="display:flex">
                        <div class="adjust-size"><?php echo $allmember['firstname']." ".$allmember['lastname'] ?></div>
                        <?php
                            $friendcheck = mysqli_query($conn,"SELECT * FROM tbl_friends WHERE member1='".$member['id']."' AND member2='".$allmember['id']."' OR member2='".$member['id']."' AND member1='".$allmember['id']."'");
                            $friendcheck=mysqli_fetch_array($friendcheck);
                            if (empty($friendcheck)) {
                        ?>
                        <div class="fixed-size icon" onclick="appendfriend(<?php echo $member['id']; echo ','; echo $allmember['id'] ?>)" id="dropdown-member-icon<?php echo $allmember['id']?>">
                        <i class="fas fa-user-plus"></i>
                        </div>
                        <?php 
                            }; 
                        ?>
                    </a>
                    <?php 
                            };
                        };
                    ?>
                </div>
            </div>
            <br/>
            <br/>
            
            <div class="title">Friends</div>
        <?php
            
//Getting friends
$friends = mysqli_query($conn,"select * FROM tbl_friends where member1='".$member['id']."' AND status='friend' OR member2='".$member['id']."' AND status='friend'");
            
            while ($row = mysqli_fetch_array($friends)) { ?>
        <div class="rows">
            <?php 
                if ($row['member1']==$member['id']) {
                    $friend_id=$row['member2'];
                } else {
                    $friend_id=$row['member1'];
                }
            $friend_profile = mysqli_query($conn,"select * FROM tbl_member where id='".$friend_id."'");
$friend_profile = mysqli_fetch_array($friend_profile);
                echo $friend_profile['firstname']." ".$friend_profile['lastname'];
            ?>
        </div>
        <?php }
        //Getting requests received
$requests = mysqli_query($conn,"select * FROM tbl_friends where member2='".$member['id']."' AND status='request'");
        
        if ($requests->num_rows!==0) {
        ?>
            <br/><br/>
            <div class="title">Requests received</div>
        <?php
            
            while ($row = mysqli_fetch_array($requests)) { ?>
        <div class="rows">
            <div class="adjust-size">
                <?php 
                    if ($row['member1']==$member['id']) {
                        $friend_id=$row['member2'];
                    } else {
                        $friend_id=$row['member1'];
                    }
                $friend_profile = mysqli_query($conn,"select * FROM tbl_member where id='".$friend_id."'");
        $friend_profile = mysqli_fetch_array($friend_profile);
                    echo $friend_profile['firstname']." ".$friend_profile['lastname'];
                ?>
            </div>
            <a class="icon fixed-size" onclick="updatefriend(<?php echo $member['id']; echo ','; echo $friend_profile['id'] ?>)" id="reqrec<?php echo $member['id']; echo ','; echo $friend_profile['id'] ?>">
                <i class="fas fa-user-check"></i>
            </a>
        </div>
        <?php };};
        //Getting requests sent
$requests = mysqli_query($conn,"select * FROM tbl_friends where member1='".$member['id']."' AND status='request'");
        
        if ($requests->num_rows!==0) {
        ?>
            <br/>
            <br/>
            <div class="title">Requests sent</div>
        <?php
            
            while ($row = mysqli_fetch_array($requests)) { ?>
        <div class="rows">
            <?php 
                if ($row['member1']==$member['id']) {
                    $friend_id=$row['member2'];
                } else {
                    $friend_id=$row['member1'];
                }
            $friend_profile = mysqli_query($conn,"select * FROM tbl_member where id='".$friend_id."'");
$friend_profile = mysqli_fetch_array($friend_profile);
                echo $friend_profile['firstname']." ".$friend_profile['lastname'];
            ?>
        </div>
        <?php };}; ?>
            </div>
    </div>
    </div>    
    
    <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/vendor/jquery/jquery-3.3.1.js"></script>

</BODY>
</HTML>