   <!-- Page Sidebar Start-->
   <nav class="navbar navbar-expand-lg navbar-mainbg">
       <a class="navbar-brand" href="index.php">
           <img src="../../assets/images/logoWhite.png" style="   height: 80px;
    margin-left: 50px;" alt="logoWhite">
       </a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
           aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <i class="fa fa-bars text-white"></i>
       </button>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav ml-auto">
               <div class="hori-selector">
                   <div class="left"></div>
                   <div class="right"></div>
               </div>
               <li class="nav-item">
                   <a class="nav-link" href="index.php"><i class="fa fa-home"></i>Kryefaqja</a>
               </li>
               <?php if ($_SESSION['role'] == 1) {?>

               <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i
                           class="fa fa-user"></i>Staf</a>
                   <ul class="dropdown-menu dropdown-menu-right list-dropdown">
                       <li>
                           <a class="dropdown-item" href="user-create.php"><i class="fa fa-user"></i>Perdoruesit</a>
                       </li>
                       <li>
                           <a class="dropdown-item" href="add_supplier.php"><i class="fa fa-industry"></i>Furnitoret</a>
                       </li>
                   </ul>
               </li>

               <li class="nav-item dropdown">
                   <a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">
                       <i class="fa fa-product-hunt"></i>Produktet
                   </a>
                   <ul class="dropdown-menu dropdown-menu-right list-dropdown">
                       <li>
                           <a class="dropdown-item" href="add_product.php"><i class="fa fa-product-hunt"></i>Produktet
                           </a>
                       </li>
                       <li>
                           <a class="dropdown-item" href="add_category.php"><i class="fa fa-clone"></i>Kategorite</a>
                       </li>
                       <li>
                           <a class="dropdown-item" href="update_products.php"><i
                                   class="fa fa-repeat"></i>Furnizimet</a>
                       </li>
                   </ul>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="orders_total.php"><i class="fa fa-money"></i>Faturat Total</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="charts.php"><i class="fa fa-bar-chart-o"></i>Grafiket</a>
               </li>

               <?php } else {?>
               <li class="nav-item">
                   <a class="nav-link" href="orders.php"><i class="fa fa-money"></i>Faturat Total</a>
               </li>
               <?php }?>
               <li class="nav-item dropdown">
                   <a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">
                       <img class="b-r-10" src="../../assets/images/user/user.png" height="20px" width="20px" alt="">
                   </a>
                   <ul class="dropdown-menu dropdown-menu-right list-dropdown">
                       <li><a class="dropdown-item" href="profile_user.php"> <i class="fa fa-user"></i><span>Profili
                               </span></a></li>
                       <li>
                           <form action="" method="POST">
                               <button class="btn btn-outline-danger dropdown-item" type="submit" name="logout"><i
                                       class="fa fa-sign-out"></i>Dil</button>
                           </form>
                       </li>
                   </ul>
               </li>
           </ul>
       </div>
   </nav>