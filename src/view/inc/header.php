<?php
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] > 0) {
    //Header con el baner del sistema
?>
  <div class="menunav">
    <div class="logotipo">
      <img src="imagenes/logo.png" alt="logotipo chacao"/>
    </div>
  </div>
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
