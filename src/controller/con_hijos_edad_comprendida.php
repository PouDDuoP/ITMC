<?php
session_start();
$_SESSION['cedula_empleado'];

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {

    $fecha_nacimiento = $_POST['fecha_desde'];
    $fecha_nacimiento_hasta = $_POST['fecha_hasta'];

    if (!empty($fecha_nacimiento) || $fecha_nacimiento != "" && !empty($fecha_nacimiento_hasta) || $fecha_nacimiento_hasta != "") {

    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include('../model/mod_empleado_hijo.php');
    $hijo = new Hijo();
    $consultar = $hijo->estadistica_hijo_fecha ($fecha_nacimiento,$fecha_nacimiento_hasta,$pgconn);

      if(pg_num_rows($consultar) > 0)
      {
        $consultar_total = $hijo->estadistica_hijo_total ($pgconn);

        $total_registros = pg_num_rows($consultar_total);
        $resultado = pg_num_rows($consultar);

        $porcentaje = ($resultado*100)/$total_registros;
// echo "$resultado---$total_registros,,, $porcentaje";


          echo "<form name='datos'>";
          echo "<input type='hidden' name='universo' value='$total_registros'>";
          echo "<input type='hidden' name='resultado' value='$resultado'>";
          echo "<input type='hidden' name='porcentaje' value='$porcentaje'>";
          echo "<input type='hidden' name='fecha_desde' value='$fecha_nacimiento'>";
          echo "<input type='hidden' name='fecha_hasta' value='$fecha_nacimiento_hasta'>";
          echo "</form>";
          echo "<script type='text/javascript'>
                  document.datos.method = 'POST';
                  document.datos.action = '../view/view_hijos_edad_comprendida_resultado.php';
                  document.datos.submit();
                </script>";
      }else{
        ?>
            <script type="text/javascript">
              alert('la busqueda de rango <?php echo "[".$fecha_nacimiento."] Al [".$fecha_nacimiento_hasta."]";?> no arrojo ningun resultado');
              window.location="../view/view_hijos_edad_comprendida.php";
            </script>
        <?php
      }
    } else {
      ?>
          <script type="text/javascript">
            alert('recuerde seleccionar rango de fechas para realizar la busqueda');
            window.location="../view/view_hijos_edad_comprendida.php";
          </script>
      <?php
    }
  }else {
    ?>
        <script type="text/javascript">
          alert('este modulo solo esta habilitado para usuario Analista de Talento Humano');
          window.location="../view/view_menu.php";
        </script>
    <?php
  }
}else {
  header('location: ../index.php');
  session_destroy();
}
?>
