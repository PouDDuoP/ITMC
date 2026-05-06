<?php
session_start();
$_SESSION['cedula_empleado'];

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {

    $rango = $_POST['rango'];

    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include('../model/mod_bitacora.php');
    $empleado = new Bitacora();
    $consultar = $empleado->consultar_bitacora ($rango,$pgconn);

      if(!empty($consultar) && $consultar != '' && $consultar != false)
      {
        $arraydatos = array();
        $i = 0;
          while ($columna = pg_fetch_array($consultar)) {
            $arraydatos[$i] = $columna;
            $i++;
          }
          $json = json_encode($arraydatos);

          // echo "$json";
          echo "<form name='datos'>";
          echo "<input type='hidden' name='consulta' value='$json'>";
          echo "<input type='hidden' name='rango' value='$rango'>";
          echo "</form>";
          echo "<script type='text/javascript'>
                  document.datos.method = 'POST';
                  document.datos.action = '../view/view_listar_cambios_realizados_resultado.php';
                  document.datos.submit();
                </script>";
      }else{
        echo "Error en la consulta a la base de Datos"."<br>";
      }
  }else {
    ?>
        <script type="text/javascript">
          alert('este modolo solo esta habilitado para usuario administrador');
          window.location="../view/view_menu.php";
        </script>
    <?php
  }
}else {
  header('location: ../index.php');
  session_destroy();
}
?>
