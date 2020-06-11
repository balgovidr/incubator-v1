<div class="header shadow-below">
            <a href="<?php echo BASE_URL ?>/home.php" class="title">Incubator</a>
            <div class="profile">
                <div class="name"><?php echo $member['firstname']." ".$member['lastname'];?><div style="display:none" name="memberid"><?php echo $member['id']; ?></div></div>
                <a href="<?php echo BASE_URL ?>/login-form.php" class="logout">Logout</a>
                </div>
        </div>