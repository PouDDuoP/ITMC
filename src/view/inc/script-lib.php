<?php
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] > 0) {
    //Head con todos los elementos de stylo y los script
?>
  <script type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" src='js/formulario2.js'></script>
  <script type="text/javascript" src="js/index.js"></script>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
  <script type="text/javascript" src="js/sl.js"></script>
  <script type="text/javascript" src="js/just_input.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- <script type="text/javascript" src="js/load_pag.js"></script> -->
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
