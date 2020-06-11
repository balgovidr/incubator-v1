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
<TITLE>Search friends | Incubator</TITLE>
<link href="<?php echo BASE_URL ?>/assets/css/style.css" type="text/css"
	rel="stylesheet" />
</HEAD>
<BODY>
	<div class="container">
        <?php include('../assets/elements/header.php') ?>
        <div class="content">
        <?php include('../assets/elements/menu.php') ?>
        <div class="content-rows">
            <div class="title">Search for members</div>
            
            <form action="search.php" method="post" class="search-container">
            <input type="text" name="search" placeholder="Search for members..." class="bar adjust-size"/>
            <input type="submit" value="Search" class="button fixed-size"/>
            
            </form>      
            
            <div class="title">Results</div>

        <?php
            
//Collecting search results
$output='';
if (isset($_POST['search'])) {
    $searchq=$_POST['search'];
    $query=mysqli_query($conn,"SELECT * FROM tbl_member WHERE firstname LIKE '%".$searchq."%' OR lastname LIKE '%".$searchq."%' OR CONCAT(firstname, ' ', lastname) LIKE '%".$searchq."%'") or die("could not search!");
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
            $query2=mysqli_query($conn,"SELECT * FROM tbl_friends WHERE member1='".$member['id']."' AND member2='".$row['id']."' OR member2='".$member['id']."' AND member1='".$row['id']."'");
                //If no relationship exists then show option to add as friend
            if ($query2->num_rows==0) {
                ?>
            <a class="fixed-size" onclick="appendfriend(<?php echo $member['id']; echo ','; echo $row['id'] ?>)" id="<?php echo $member['id']; echo ','; echo $row['id'] ?>">
                <i class="fas fa-user-plus"></i>
            </a>
            <?php }; ?>
        </div>
        <?php };
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