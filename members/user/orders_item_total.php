
  <?php
  include '../../functions.php';
  ob_start();
  session_start();

  $id_user = $_SESSION['user_id'];

  $id_order = $_GET['nr'];

  include '../invoice.php';

  ?>

