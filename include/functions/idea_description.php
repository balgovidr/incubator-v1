<?php
include '../../lib/database.php';
  if(!empty($_REQUEST['id'])) {
    
    $id = $_REQUEST['id'];
    $memberid = $_REQUEST['memberid'];
    if (!is_numeric($id) || !is_numeric($memberid)) {
      $id = 'error';
      $memberid = 'error';
    }
    
    $ideas2 = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE id='".$id."'");
    $ideas2 = mysqli_fetch_array($ideas2);
  };
?>
<!-- Tab links -->
<div class="tab fixed-size">
  <button class="tablinks" onclick="opentab(event, 'Edit')" id="defaultOpen">Edit</button>
  <button class="tablinks" onclick="opentab(event, 'Share')">Share</button>
  <button class="tablinks" onclick="updateidea(<?php echo $id; ?>)" id="save<?php echo $id; ?>">Save</button>
  <button class="tablinks" onclick="opentab(event, 'Delete')">Delete</button>
</div>
      
<!-- Tab content -->
<div id="Edit" class="tabcontent adjust-size">
  <div id="editor">
      <?php echo $ideas2['description']; ?>
  </div>
</div>

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
  <div class="title">Find more friends to share this idea with:</div>
  <div class="dropdown">
    <button onclick="dropdown('idea-dropdown')" class="dropbtn">Select a friend <i class="fas fa-caret-down"></i></button>
    <div id="idea-dropdown" class="dropdown-content">
      <input type="text" placeholder="Search.." id="idea-input" class="dropdown-input" onkeyup="filterFunction('idea-dropdown','idea-input')">
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
      <a onclick="addfriendtoidea(<?php echo $id.",".$friend_profile['id'].",'".$friend_profile['firstname']." ".$friend_profile['lastname']."'" ?>)" id="dropdown-idea<?php echo $friend_profile['id']?>"><?php echo $friend_profile['firstname']." ".$friend_profile['lastname'] ?></a>
        <?php };
            };
        ?>

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

    <script>
  var quill = new Quill('#editor', {
    theme: 'snow'
  });
        // Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>