<div class="header shadow-below">
    <a href="<?php echo BASE_URL ?>/home.php" class="title">Incubator</a>
    <div class="profile">
        <div class="name"><a href="<?php echo BASE_URL ?>/Profile_Page.php"><?php echo $member['firstname']." ".$member['lastname'];?></a>
            <div style="display:none" name="memberid"><?php echo $member['id']; ?></div>
        </div>
        <a href="<?php echo BASE_URL ?>/login-form.php" class="logout">Logout</a>
    </div>
</div>