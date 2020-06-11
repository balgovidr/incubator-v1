<?php
session_start();
include_once('../lib/database.php');
$username = $_SESSION["username"];

//Getting member details
$member = mysqli_query($conn,"select * FROM tbl_member where username='".$username."'");
$member = mysqli_fetch_array($member);

$groupq=$_POST['group'];

//Getting group name
$groupname = mysqli_query($conn,"SELECT title FROM tbl_group where id='".$groupq."'");
$groupname=mysqli_fetch_array($groupname);

?>
<HTML>
<HEAD>
    <TITLE>Search friends | Incubator</TITLE>
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
            <div class="title">Search for friends to add to <?php echo $groupname['title'] ?></div>
        
            <form action="friend_search.php" method="post" class="search-container">
            <input type="text" name="search" placeholder="Search for friends..." class="bar adjust-size"/>
            <input type="number" name="group" style="display:none" value="<?php echo $groupq ?>"/>
            <input type="submit" value="Search" class="button fixed-size"/>
            
            </form>
                <br/>
                <br/>
                <div class="title">Results</div>
        <?php

//Getting friends
$query = mysqli_query($conn,"select * FROM tbl_friends where member1='".$member['id']."' AND status='friend' OR member2='".$member['id']."' AND status='friend'");
            
            while ($row = mysqli_fetch_array($query)) {
                if ($row['member1']==$member['id']) {
                    $friend_id=$row['member2'];
                } else {
                    $friend_id=$row['member1'];
                };
                $friends[]=$friend_id;
            };
            
//Collecting search results
$output='';
if (isset($_POST['search'])) {
    $searchq=$_POST['search'];
    $query=mysqli_query($conn,"SELECT * FROM tbl_member WHERE firstname LIKE '%".$searchq."%' OR lastname LIKE '%".$searchq."%' OR CONCAT(firstname, ' ', lastname) LIKE '%".$searchq."%'") or die("could not search!");
    $query2=mysqli_query($conn,"SELECT * FROM tbl_group WHERE id='".$groupq."'");
    $query2=mysqli_fetch_array($query2);
    $members=explode("#",$query2['members']);
    //If there are no results
    if($query->num_rows===0) {
        ?>
            <div class="rows">
            <?php 
                echo "There were no search results!";
            ?>
        </div>
            <?php
    } else {
        //If there are results
        while ($row = mysqli_fetch_array($query)) {
            //Don't show yourself
            if ($row['id']!==$member['id']) {
                if (in_array($row['id'],$friends)) {
            ?>
        <div class="rows">
            <div class="adjust-size">
            <?php 
                echo $row['firstname'];
                echo " ";
                echo $row['lastname'];
            ?>
                </div>
            <?php
                //Search if a relationship exists already
            if (in_array($row['id'],$members)) {} else {
            
                //If no relationship exists then show option to add to group
                ?>
            <a class="icon fixed-size" onclick="addtogroup(<?php echo $groupq; echo ','; echo $row['id'] ?>)" id="<?php echo $groupq; echo ','; echo $row['id'] ?>">
                <i class="fas fa-plus"></i>
            </a>
            <?php }; ?>
        </div>
        <?php };
                };
            };
                };
};
            ?>
        </div>
    </div>
    </div>
    
    <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/vendor/jquery/jquery-3.3.1.js"></script>

</BODY>
</HTML>