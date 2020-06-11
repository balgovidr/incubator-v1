<?php
include '../../lib/database.php';
        if(!empty($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $memberid = $_REQUEST['memberid'];
            $ideas2 = mysqli_query($conn,"select * FROM tbl_ideas where id='".$id."'");
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
          <div class="title">Currently shared with:</div>
          <?php 
          if ($ideas2['share_friends']!=null) {
          $friends=explode("#",$ideas2['share_friends']);
          foreach ($friends as $friend) {
              $friend = mysqli_query($conn,"select * FROM tbl_member where id='".$friend."'");
              $friend = mysqli_fetch_array($friend);
                if ($friend!=null) {?>
          <a class="rows"><?php echo $friend['firstname'] ." " .$friend['lastname']; ?></a>
          <?php
          };};};
          ?>
          <br/>
          <br/>
          <div class="title">And shared with the groups:</div>
          <div id="share-group-add"></div>
          <?php 
          if ($ideas2['share_groups']!=null) { ?>
          <?php
          $idea_groups=explode("#",$ideas2['share_groups']);
          foreach ($idea_groups as $idea_group) {
              $idea_group = mysqli_query($conn,"select * FROM tbl_group where id='".$idea_group."'");
              $idea_group = mysqli_fetch_array($idea_group); 
          if ($idea_group!=null) {?>
          <a class="rows"><?php echo $idea_group['title'] ?></a>
          <?php
          };};};
          ?>
          <br/>
          <br/>
          <div class="title">Find more friends to share this idea with:</div>
          <form class="search-container" action="<?php echo BASE_URL ?>/friends/friend_search_idea.php" method="post">
            <input type="text" class="bar adjust-size" name="search" placeholder="Search for friends..."/>
              <input type="number" name="idea" style="display:none" value="<?php echo $ideas2['id'] ?>"/>
            <input type="submit" value="Search" class="button fixed-size"/>
            </form>
          
          
          <div class="title">Or select a group to share this idea with:</div>
          <div class="dropdown">
              <button onclick="dropdown('group-dropdown')" class="dropbtn">Select a group <i class="fas fa-caret-down"></i></button>
              <div id="group-dropdown" class="dropdown-content">
                <input type="text" placeholder="Search.." id="group-input" class="dropdown-input" onkeyup="filterFunction('group-dropdown','group-input')">
                <?php
    $user_groups = mysqli_query($conn,"select * FROM tbl_group where member_id='".$memberid."'");
    while ($user_group = mysqli_fetch_array($user_groups)) {
                  if (!in_array($user_group['id'],$idea_groups) || $idea_groups==null) {?>
                <a onclick="addgrouptoidea(<?php echo $id.",".$user_group['id'].",'".$user_group['title']."'" ?>)" id="dropdown-group<?php echo $user_group['id']?>"><?php echo $user_group['title'] ?></a>
                  <?php };}; ?>

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