
<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header"><a class="navbar-brand" href="#"><img src="<?php echo $site_logo ?>" alt="<?php echo $site_name ?>"></a>
        <!--<a class="sidebar-toggle"><i class="icon-paragraph-justify2"></i></a>-->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons"><span class="sr-only">Toggle navbar</span><i class="icon-grid3"></i></button>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar"><span class="sr-only">Toggle navigation</span><i class="icon-paragraph-justify2"></i></button>
    </div>
    <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">



        <li class="user dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $profile_image ?>" alt="userimage"><span><?php echo $profile_names ?></span><i class="caret"></i></a>
            <ul class="dropdown-menu dropdown-menu-right icons-right">
                <li><a href="profile"><i class="icon-user"></i> Profile</a></li>

                <?php if($_SESSION['user']=="admin") { ?>
                    <li><a href="settings"><i class="icon-cog"></i> Settings</a></li>
                    <?php
                }
                ?>
                <li><a href="logout"><i class="icon-exit"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</div>