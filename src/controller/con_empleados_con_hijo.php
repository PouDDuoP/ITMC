<?php
session_start();
$_SESSION['cedula_empleado'];

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {


    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include('../model/mod_empleado.php');
    $empleado = new Empleado();
    $consultar = $empleado->estadistica_empleado_con_hijo ($pgconn);

      if(pg_num_rows($consultar) > 0)
      {
        $consultar_total = $empleado->estadistica_empleado_total ($pgconn);

        $total_registros = pg_num_rows($consultar_total);
        $resultado = pg_num_rows($consultar);

        $porcentaje = ($resultado*100)/$total_registros;
// echo "$resultado---$total_registros,,, $porcentaje";


          echo "<form name='datos'>";
          echo "<input type='hidden' name='universo' value='$total_registros'>";
          echo "<input type='hidden' name='resultado' value='$resultado'>";
          echo "<input type='hidden' name='porcentaje' value='$porcentaje'>";
          echo "</form>";
          echo "<script type='text/javascript'>
                  document.datos.method = 'POST';
                  document.datos.action = '../view/view_empleado_con_hijo_resultado.php';
                  document.datos.submit();
                </script>";
      }else{
        ?>
            <script type="text/javascript">
              alert('Actualmente no hay empleados con hijos registrados');
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
