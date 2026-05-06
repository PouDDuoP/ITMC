<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] > 0) {
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
  </head>
  <body>
    <header id="header">
      <?php include_once 'inc/header.php'; ?>
    </header>
    <?php include_once 'inc/nav.php'; ?>



    <?php include_once 'inc/script-lib.php'; ?>
  </body>
</html>
<?php
  }else {
    ?>
      <script type="text/javascript">
        alert('perfil '+<?php $_SESSION['perfil'] ?>+' no esta registrado');
          window.location="../index.php";
      </script>
    <?php
  }
}else {
  header('location: ../index.php');
  session_destroy();
}
?>
