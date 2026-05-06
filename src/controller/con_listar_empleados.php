<?php
session_start();
$_SESSION['cedula_empleado'];

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2) {

    $rango = $_POST['rango'];
    $cedula_id = $_POST['cedula'];
    $fecha_ingreso = $_POST['fecha_desde'];
    $fecha_hasta = $_POST['fecha_hasta'];
    $departamento = $_POST['departamento'];
    $sueldo = $_POST['monto_desde'];
    $sueldo_hasta = $_POST['monto_hasta'];
    $status  = $_POST['status'];

    if (!empty($rango) || $rango != "" && !empty($status) || $status != "") {

    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include('../model/mod_empleado.php');
    $empleado = new Empleado();
    $consultar = $empleado->filtrar_empleados ($cedula_id,$fecha_ingreso,$fecha_hasta,$departamento,$sueldo,$sueldo_hasta,$status,$rango,$pgconn);

      if(!empty($consultar) && $consultar != '' && $consultar != false)
      {
        $arraydatos = array();
        $i = 0;
          while ($columna = pg_fetch_array($consultar)) {
            $arraydatos[$i] = $columna;
            $i++;
          }
          $json = json_encode($arraydatos);

          echo "<form name='datos'>";
          echo "<input type='hidden' name='consulta' value='$json'>";
          echo "<input type='hidden' name='rango' value='$rango'>";
          echo "</form>";
          echo "<script type='text/javascript'>
                  document.datos.method = 'POST';
                  document.datos.action = '../view/view_listar_empleados_resultado.php';
                  document.datos.submit();
                </script>";
      }else{
        echo "Error en la consulta a la base de Datos"."<br>";
      }
    } else {
      ?>
          <script type="text/javascript">
            alert('recuerde seleccionar rango y status para realizar la busqueda');
            window.location="../view/view_listar_empleados.php";
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
