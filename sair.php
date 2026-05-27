<?php 
  include('lib/Config.php');
    
  unset($_SESSION['sess_cliente_id']);

  if (isset($_SESSION['userData']['id'])&&$_SESSION['userData']['id']!='') {
    unset($_SESSION['userData']);
  }

  header('Location: '.URL)
?>