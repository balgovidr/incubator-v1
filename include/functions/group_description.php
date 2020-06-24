<?php
session_start();
include '../../lib/database.php';
$memberid = $_SESSION["MemberId"];

        if(!empty($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            echo '<script>console.log("'.$id.'")</script>';

            //Making sure that $id is a number, prevent SQL injection
            if (!is_numeric($id)) {
                $id = 'error';
            }

            $group2 = mysqli_query($conn,"SELECT * FROM tbl_group WHERE id='".$id."'");
            $group2 = mysqli_fetch_array($group2);
        };

        //Fetching the ids of the members in this group
        $members=explode("#",$group2['members']);
    ?>
      <!-- Tab links -->
      <div class="tab fixed-size">
        <button class="tablinks" onclick="opentab(event, 'Members')" id="defaultOpen">Members</button>
        <button class="tablinks" onclick="opentab(event, 'Delete')">Delete</button>
      </div>
      
      <!-- Tab content -->
      <!-- Member tab -->
      <div id="Members" class="tabcontent adjust-size padding15">
        <div class="title">Search for friends to add to this group</div>

        <div class="dropdown">
                <button onclick="dropdown('friend-dropdown')" class="dropbtn">Select a friend <i class="fas fa-caret-down"></i></button>
                <!-- The stuff in the div below only pops up when the button in the div above is clicked -->
                <div id="friend-dropdown" class="dropdown-content">
                    <!-- Input box where the search query or friend's name is typed -->
                    <input type="text" placeholder="Search.." id="friend-input" class="dropdown-input" onkeyup="filterFunction('friend-dropdown','friend-input')">
                    <?php
                    //Fetching all of the member's friends
                    $user_friends = mysqli_query($conn,"SELECT * FROM tbl_friends WHERE member1='".$memberid."' AND status='friend' OR member2='".$memberid."' AND status='friend'");
                        //For each friend loop
                        while ($user_friend = mysqli_fetch_array($user_friends)) {
                            //Figuring out what the friend's ID is
                            if ($user_friend['member1']==$memberid) {
                                $friend_id=$user_friend['member2'];
                            } else {
                                $friend_id=$user_friend['member1'];
                            };

                            //Only displaying the friend if they aren't already in the group
                            if (!in_array($friend_id,$members) || $members==null) {
                            
                                //Fetching the friend's details
                                $friend_profile = mysqli_query($conn,"SELECT * FROM tbl_member where id='".$friend_id."'");
                                $friend_profile = mysqli_fetch_array($friend_profile);
                    ?>
                    <!-- Displaying the friend's name and option to add to group -->
                    <a onclick="addtogroup(<?php echo $id.",".$friend_profile['id'].",'".$friend_profile['firstname']." ".$friend_profile['lastname']."'" ?>)" id="dropdown-friend<?php echo $friend_profile['id']?>"><?php echo $friend_profile['firstname']." ".$friend_profile['lastname'] ?></a>
                    <?php 
                            };
                        };
                    ?>

                    <!-- Additional bit for if you didn't find the person you were searching for -->
                    <form onsubmit="Invite()" class="block-flex flex-column">
                        <div class="permanent">
                        <span><strong>Didn't find who you were looking for?</strong></span>
                        </div>
                        <div class="flex-row permanent">
                        <span>Make sure they've been added as your friend here:&nbsp;&nbsp;&nbsp;</span>
                        <div class="button" href="<?php echo BASE_URL ?>/friends/index.php">Friends</div>
                        </div>
                        <div class="flex-row permanent">
                        <span class="fixed-size">or invite them with their email below:&nbsp;&nbsp;&nbsp;</span>
                        <!-- Input box for inviting new users through their email -->
                        <input class="adjust-size" type="text" id="invite-email" placeholder="Email of your friend..."/>&nbsp;
                        <div onclick="Invite()" class="icon fixed-size"><i class="fas fa-angle-double-right"></i></div>
                        </div>
                    </form>

                </div>
            </div>

        <div class="title" id="group-member-title">Members of this group</div>
        <?php 
            //For each of the members in the array, set the id as $row2
            foreach ($members as $row2) {
            //Only if the row2 ID is not blank
            if ($row2!='') {
                echo '<script>console.log("'.$row2.'")</script>';
                $member2 = mysqli_query($conn,"SELECT * FROM tbl_member WHERE id='".$row2."'");
                $member2 = mysqli_fetch_array($member2);
        ?>
            <!-- Member name and option to remove from group -->
            <div class="rows" id="member<?php echo $member2['id'] ?>">
                <a class="adjust-size">
                    <?php echo $member2['firstname'] ." " .$member2['lastname']; ?>
                </a>
                <a class="fixed-size icon" onclick="removememberfromgroup(<?php echo $id.','.$member2['id'] ?>)">
                    <i class="fas fa-user-minus"></i>
                </a>
            </div>
        <?php
            };};
        ?>
      </div>

<div id="Delete" class="tabcontent adjust-size">
    <div class="block-flex horizontal-center vertical-center">
<div class="title">Are you sure you would like to delete this group?</div>
        <br/>
    <div><button class="button" onclick="deletegroup(<?php echo $id; ?>)">Yes</button>
        <button class="button" onclick="opentab(event, 'Edit')">No</button>
        </div>
    </div>
</div>

<script>
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>