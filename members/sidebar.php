<?php $role_user = $_SESSION['role'];

?>

<header class="main-nav close_icon">
    <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light" src="" alt=""><img class="img-fluid for-dark" src="../../assets/images/logo/logo_dark.png" alt=""></a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="grid" id="sidebar-toggle">
            </i></div>
    </div>
    <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid" src="../../assets/images/logo/logo-icon.png" alt=""></a></div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn"><a href="index.html"><img class="img-fluid" src="../../assets/images/logo/logo-icon.png" alt=""></a>
                        <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                    </li>
                    <?php if ($role_user == 1) {
                    ?>
                        <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="user"></i><span class="">Perdoruesit</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="user-create.php">Krijo / Modifiko Perdorues</a></li>

                            </ul>
                        </li>
                        <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="users"></i><span class="">Furnizuesit</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="add_supplier.php">Krijo / Modifiko furnizues</a></li>

                            </ul>
                        </li>
                        <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="database"></i> <span class=""> Produkte</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="add_product.php">Shto / Modfiko Produkt</a></li>
                                <li><a href="">Lista Produkteve</a></li>
                                <li><a href="">Sasia aktuale sipas produkteve</a></li>


                            </ul>
                        </li>
                        <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="dollar-sign"></i><span>Aktiviteti biznesit</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="orders_total.php">Faturat / total</a></li>
                                <li><a href="">Shitjet interval kohor</a></li>

                            </ul>
                        </li>

                    <?php
                    } elseif ($role_user == 2) { ?>
                        <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="bookmark"></i><span>Shitjet </span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="orders.php">Faturat</a></li>

                            <?php } ?>
                            </ul>
                        </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>