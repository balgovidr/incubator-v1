<?php
include '../../lib/database.php';
        if(!empty($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
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
          <div class="title">Members of this group</div>
          <?php $members=explode("#",$group2['members']);
          foreach ($members as $row2) {
              $member2 = mysqli_query($conn,"select * FROM tbl_member where id='".$row2."'");
              $member2 = mysqli_fetch_array($member2); ?>
          <a class="rows"><?php echo $member2['firstname'] ." " .$member2['lastname']; ?></a>
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