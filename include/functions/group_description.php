<?php
include '../../lib/database.php';
        if(!empty($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $memberid = $_REQUEST['memberid'];
            if (!is_numeric($id) || !is_numeric($memberid)) {
                $id = 'error';
                $memberid = 'error';
            }

            $group2 = mysqli_query($conn,"select * FROM tbl_group where id='".$id."'");
            $group2 = mysqli_fetch_array($group2);
        };
    ?>
      <!-- Tab links -->
      <div class="tab fixed-size">
        <button class="tablinks" onclick="opentab(event, 'Members')" id="defaultOpen">Members</button>
        <button class="tablinks" onclick="opentab(event, 'Search')">Search</button>
        <button class="tablinks" onclick="opentab(event, 'Delete')">Delete</button>
      </div>
      
      <!-- Tab content -->
      <div id="Members" class="tabcontent adjust-size padding15">
          <div class="title" id="group-member-title">Members of this group</div>
          <?php $members=explode("#",$group2['members']);
          foreach ($members as $row2) {
              $member2 = mysqli_query($conn,"select * FROM tbl_member where id='".$row2."'");
              $member2 = mysqli_fetch_array($member2); ?>
                <div class="rows" id="member<?php echo $member2['id'] ?>">
                    <a class="adjust-size">
                        <?php echo $member2['firstname'] ." " .$member2['lastname']; ?>
                    </a>
                    <a class="fixed-size icon" onclick="removememberfromgroup(<?php echo $id.','.$member2['id'] ?>)">
                        <i class="fas fa-user-minus"></i>
                    </a>
          <?php
          };
          ?>
      </div>
      
      <div id="Search" class="tabcontent adjust-size">
          <div class="title">Search for friends to add to this group</div>
          <form action="<?php echo BASE_URL ?>/friends/friend_search.php" method="post" class="search-container">
            <input type="text" name="search" placeholder="Search for friends..." class="bar adjust-size"/>
              <input type="number" name="group" style="display:none" value="<?php echo $id ?>"/>
            <input type="submit" value="Search" class="button fixed-size"/>            
            </form>


            <div class="dropdown">
                <button onclick="dropdown('friend-dropdown')" class="dropbtn">Select a friend <i class="fas fa-caret-down"></i></button>
                <div id="friend-dropdown" class="dropdown-content">
                <input type="text" placeholder="Search.." id="friend-input" class="dropdown-input" onkeyup="filterFunction('friend-dropdown','friend-input')">
                    <?php
                    $user_friends = mysqli_query($conn,"select * FROM tbl_friends WHERE member1='".$memberid."' AND status='friend' OR member2='".$memberid."' AND status='friend'");
                        while ($user_friend = mysqli_fetch_array($user_friends)) {
                        if ($user_friend['member1']==$memberid) {
                            $friend_id=$user_friend['member2'];
                        } else {
                            $friend_id=$user_friend['member1'];
                        };
                        $friend_profile = mysqli_query($conn,"select * FROM tbl_member where id='".$friend_id."'");
                        $friend_profile = mysqli_fetch_array($friend_profile);

                        if (!in_array($friend_profile['id'],$friends) || $friends==null) {
                    ?>
                <a onclick="addtogroup(<?php echo $id.",".$friend_profile['id'].",'".$friend_profile['firstname']." ".$friend_profile['lastname']."'" ?>)" id="dropdown-friend<?php echo $friend_profile['id']?>"><?php echo $friend_profile['firstname']." ".$friend_profile['lastname'] ?></a>
                    <?php };
                        };
                    ?>

                </div>
            </div>
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