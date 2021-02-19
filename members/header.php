<div class="page-main-header close_icon">
    <div class="main-header-right row m-0">
        <form class="form-inline search-full" action="#" method="get">
            <div class="form-group w-100">
                <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                        <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .." name="q" title="" autofocus>
                        <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                    </div>
                    <div class="Typeahead-menu"></div>
                </div>
            </div>
        </form>
        <div class="main-header-left">
            <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="../../assets/images/logo/logo.png" alt=""></a></div>
            <!-- <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="grid" id="sidebar-toggle">
                </i></div> -->
        </div>

        <div class="nav-right col-8 pull-right right-menu ml-auto">
            <ul class="nav-menus">
                <!-- <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li> -->
                <li class="profile-nav onhover-dropdown p-0">
                    <div class="media profile-media"><img class="b-r-10" src="../assets/images/dashboard/profile.jpg" alt="">
                        <div class="media-body"><span>Emay Walter</span>
                            <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
                        </div>
                    </div>

                    <?php if ($_SESSION['role']  == 2) {
                        $log = '../../index.php';
                    } elseif ($_SESSION['role']  == 1) {
                        $log = '../../index.php';
                    }
                    ?>
                    <form action="<?php echo $log; ?>" method="POST">
                        <ul class="profile-dropdown onhover-show-div">
                            <li><a href=""><i data-feather="user"></i><span>Account</span></a></li>
                            <li> <button type="submit" name="logout" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout-variant"></i>
                                    <span>Logout</span>
                                </button></li>
                        </ul>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>