<div class="header shadow-below">
    <a onclick="ToggleDisplay2('menu','block')" id="header-menu-button" class="hidden">
        <i class="fas fa-bars"></i>
    </a>
    <a href="<?php echo BASE_URL ?>/home.php" class="title">Incubator</a>
<<<<<<< HEAD
    <div class="profile">
        <div class="name"><a href="<?php echo BASE_URL ?>/Profile_Page.php"><?php echo $member['firstname']." ".$member['lastname'];?></a>
=======
    <div class="profile" id="header-profile">
        <div class="name"><?php echo $member['firstname']." ".$member['lastname'];?>
>>>>>>> cbd873f543f4c3ed411b3f5025ba37578fcaaac3
            <div style="display:none" name="memberid"><?php echo $member['id']; ?></div>
        </div>
        <a href="<?php echo BASE_URL ?>/include/functions/logout.php" class="logout">Logout</a>
    </div>
</div>