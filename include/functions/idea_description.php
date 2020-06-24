<?php
session_start();
include '../../lib/database.php';
  if(!empty($_REQUEST['id'])) {
    
    $id = $_REQUEST['id'];
    $memberid = $_SESSION["MemberId"];
    if (!is_numeric($id)) {
      $id = 'error';
    }
    
    $ideas2 = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE id='".$id."'");
    $ideas2 = mysqli_fetch_array($ideas2);
  };
?>
<!-- Tab links -->
<div class="tab fixed-size">
  <button class="tablinks" onclick="opentab(event, 'Edit')" id="defaultOpen">Edit</button>
  <button class="tablinks" onclick="updateidea(<?php echo $id; ?>)" id="save<?php echo $id; ?>">Save</button>
  <?php
    //To make sure that the share tab is only available if the idea is yours
      if ($ideas2['member_id']==$memberid) {
  ?>
  <button class="tablinks" onclick="opentab(event, 'Share')">Share</button>
  <button class="tablinks" onclick="opentab(event, 'Delete')">Delete</button>
  <?php
    };
  ?>
</div>
      
<!-- Tab content -->
<div id="Edit" class="tabcontent adjust-size">
  <div id="editor">
      <?php echo $ideas2['description']; ?>
  </div>
</div>

<?php
//To make sure that the share tab is only available if the idea is yours
  if ($ideas2['member_id']==$memberid) {
?>

<div id="Share" class="tabcontent adjust-size padding15">
  <div class="title" id="share-friend-title">Currently shared with:</div>
  <?php 
    $friends=explode("#",$ideas2['share_friends']);
    if ($ideas2['share_friends']!=null) {
      foreach ($friends as $friend) {
        $friend = mysqli_query($conn,"SELECT * FROM tbl_member WHERE id='".$friend."'");
        $friend = mysqli_fetch_array($friend);
          if ($friend!=null) {
  ?>
  <div class="rows" id="friend<?php echo $friend['id'] ?>">
    <a class="adjust-size">
      <?php echo $friend['firstname'] ." " .$friend['lastname']; ?>
    </a>
    <a class="fixed-size icon" onclick="removefriendfromidea(<?php echo $id.",".$friend['id'] ?>)">
      <i class="fas fa-user-minus"></i>
    </a>
  </div>
  <?php
          };
      };
    };
  ?>
  <br/>
  <br/>
  <div class="title" id="share-group-title">And shared with the groups:</div>
  <?php 
    if ($ideas2['share_groups']!=null) {
      $idea_groups=explode("#",$ideas2['share_groups']);
      foreach ($idea_groups as $idea_group) {
        $idea_group = mysqli_query($conn,"select * FROM tbl_group where id='".$idea_group."'");
        $idea_group = mysqli_fetch_array($idea_group); 
        if ($idea_group!=null) {
  ?>
  <div class="rows" id="group<?php echo $idea_group['id'] ?>">
    <a class="adjust-size">
      <?php echo $idea_group['title'] ?>
    </a>
    <a class="fixed-size icon" onclick="removegroupfromidea(<?php echo $id.",".$idea_group['id'] ?>)">
      <i class="fas fa-minus-circle"></i>
    </a>
  </div>
  <?php
        };
      };
    };
    ?>
  <br/>
  <br/>
  <!-- Search function to find friends to share it with -->
  <div class="title">Find more friends to share this idea with:</div>
  <div class="dropdown">
    <button onclick="dropdown('idea-dropdown')" class="dropbtn">Select a friend <i class="fas fa-caret-down"></i></button>
    <!-- All of the stuff in the div below is hidden until the dropdown is activated by the user-->
    <div id="idea-dropdown" class="dropdown-content">
      <!-- Search bar is always shown when dropdown is selected-->
      <input type="text" placeholder="Search.." id="idea-input" class="dropdown-input" onkeyup="filterFunction('idea-dropdown','idea-input')">
        <?php
          //This script finds all of the friends of the user to be displayed to them
          $user_friends = mysqli_query($conn,"select * FROM tbl_friends WHERE member1='".$memberid."' AND status='friend' OR member2='".$memberid."' AND status='friend'");
            while ($user_friend = mysqli_fetch_array($user_friends)) {
              //Goes through all of the rows of friends found from the tbl_friends table
              if ($user_friend['member1']==$memberid) {
                //If the column member1 has the user's id, the 2nd column is the friend's id
                $friend_id=$user_friend['member2'];
              } else {
                //If the column member2 has the user's id, the 1st column is the friend's id
                $friend_id=$user_friend['member1'];
              };
              //Fetches the friend's details
              $friend_profile = mysqli_query($conn,"select * FROM tbl_member where id='".$friend_id."'");
              $friend_profile = mysqli_fetch_array($friend_profile);
              
              //If the idea is already shared with a friend, then their name is not repeated again in the list
              if (!in_array($friend_profile['id'],$friends) || $friends==null) {
        ?>
      <!-- The name of the friend is shown, this will be filtered using the search bar. On select, the friend is added to the idea's shared list -->
      <a onclick="addfriendtoidea(<?php echo $id.",".$friend_profile['id'].",'".$friend_profile['firstname']." ".$friend_profile['lastname']."'" ?>)" id="dropdown-idea<?php echo $friend_profile['id']?>"><?php echo $friend_profile['firstname']." ".$friend_profile['lastname'] ?></a>
        <?php };
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
    
  <div class="title">Or select a group to share this idea with:</div>
  <div class="dropdown">
    <button onclick="dropdown('group-dropdown')" class="dropbtn">Select a group <i class="fas fa-caret-down"></i></button>
    <div id="group-dropdown" class="dropdown-content">
      <input type="text" placeholder="Search.." id="group-input" class="dropdown-input" onkeyup="filterFunction('group-dropdown','group-input')">
        <?php
          $user_groups = mysqli_query($conn,"select * FROM tbl_group where member_id='".$memberid."'");
            while ($user_group = mysqli_fetch_array($user_groups)) {
              if (!in_array($user_group['id'],$idea_groups) || $idea_groups==null) {
        ?>
      <a onclick="addgrouptoidea(<?php echo $id.",".$user_group['id'].",'".$user_group['title']."'" ?>)" id="dropdown-group<?php echo $user_group['id']?>"><?php echo $user_group['title'] ?></a>
        <?php };
            };
        ?>

    </div>
  </div>
  </br>
  </br>
  
  <!--Creating a default sharing friends and groups using the settings above -->
  <div class="button" id="DefaultShareButton" onclick="SetDefaultShare(<?php echo $id ?>); document.getElementById('DefaultShareButton').innerHTML='Done!'">Make this your default sharing setting</div>

</div>

<div id="Delete" class="tabcontent adjust-size padding15 horizontal-center vertical-center">
    <div class="block-flex horizontal-center vertical-center">
    <div class="title">Are you sure you would like to delete this idea?</div>
    <br/>
    <div><button class="button" onclick="deleteidea(<?php echo $id; ?>)">Yes</button>
        <button class="button" onclick="opentab(event, 'Edit')">No</button>
    </div>
    </div>
</div>

<?php
  }
?>

    <script>
  var quill = new Quill('#editor', {
    theme: 'snow'
  });
        // Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>