<div class="header shadow-below">
    <a onclick="ToggleDisplay2('menu','block')" id="header-menu-button" class="hidden">
        <i class="fas fa-bars"></i>
    </a>
    <a href="<?php echo BASE_URL ?>/home.php" class="title">Incubator</a>
    <div class="profile" id="header-profile">
        <div class="name"><?php echo $member['firstname']." ".$member['lastname'];?>
            <div style="display:none" name="memberid"><?php echo $member['id']; ?></div>
        </div>
        <a href="<?php echo BASE_URL ?>/include/functions/logout.php" class="logout">Logout</a>
    </div>
</div>