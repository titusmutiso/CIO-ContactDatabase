<div class="sidebar collapse">
    <div class="sidebar-content">
      <!-- User dropdown -->
      <div class="user-menu dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="uploads/users/avatar.png" alt="Userimage">
        <div class="user-info"><?php echo $profile_username ?> <span><?php echo $_SESSION['user'] ?></span></div>
        </a>
        
      </div>
      <!-- /user dropdown -->
      <!-- Main navigation -->
      <ul class="navigation">
        <li <?php if ($page=="dashboard"){ ?>class="active"<?php }?>><a href="dashboard"><span>Dashboard</span> <i class="icon-screen2"></i></a></li>
        <li <?php if ($mainpage=="contacts"){ ?>class="active"<?php }?>><a href="#" class="expand"><span>Contacts</span> <i class="fa fa-clipboard" aria-hidden="true"></i></a>
		<ul>
            <li <?php if ($page=="create-contact"){ ?>class="active"<?php }?> ><a href="create-contact">Create Contact</a></li>
            <li <?php if ($page=="contacts"){ ?>class="active"<?php }?>><a href="contacts">View Contacts</a></li>
            <li <?php if ($page=="contacts"){ ?>class="active"<?php }?>><a href="designation">View Designation</a></li>

          </ul>
		</li>
          <li <?php if ($mainpage=="company"){ ?>class="active"<?php }?>><a href="#" class="expand"><span>Companies / Industry</span> <i class="fa fa-clipboard" aria-hidden="true"></i></a>
              <ul>
                  <li <?php if ($page=="create-company"){ ?>class="active"<?php }?> ><a href="create-company">Create Company</a></li>
                  <li <?php if ($page=="company"){ ?>class="active"<?php }?>><a href="companies">View Companies</a></li>
                  <li <?php if ($page=="company"){ ?>class="active"<?php }?>><a href="industries">Industries</a></li>
                  <li <?php if ($page=="company"){ ?>class="active"<?php }?>><a href="countries">Countries</a></li>

              </ul>
          </li>


          <?php if($_SESSION['user']=="admin") { ?>
              <li <?php if ($mainpage == "users"){ ?>class="active"<?php } ?>><a href="#"
                                                                                 class="expand"><span>Users / Reports</span> <i
                              class="fa fa-users"></i></a>
                  <ul>

                      <li <?php if ($page == "add-user"){ ?>class="active"<?php } ?>><a href="create-user">Add User</a>
                      </li>
                      <li <?php if ($page == "users"){ ?>class="active"<?php } ?>><a href="users">View Users</a></li>
                      <li <?php if ($page == "activity"){ ?>class="active"<?php } ?>><a href="history">User Log</a></li>
                  </ul>
              </li>
              <?php
          }
          ?>
          <?php if($_SESSION['user']=="admin") { ?>
              <li <?php if ($page == "settings"){ ?>class="active"<?php } ?>><a href="settings"><span>Settings</span> <i
                              class="fa fa-cogs" aria-hidden="true"></i></a></li>
              <?php
          }
          ?>
          <li <?php if ($page=="profile"){ ?>class="active"<?php }?>><a href="profile"><i class="icon-user"></i> Profile</a></li>
      </ul>



      <!-- /main navigation -->
    </div>
  </div>