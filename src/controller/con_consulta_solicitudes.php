<?php
session_start();
date_default_timezone_set('America/La_Paz');

require_once '../inc/auth.php';
require_auth();
require_perfil();
// $fecha_actual = date('Y-m-d');
//     echo $_SESSION['cedula_empleado'];
//     echo "<br>";
//     echo 1;
//         echo "<br>";
//     echo "$fecha_actual";
//         echo "<br>";
//     echo $_POST['tipo_beneficio'];
//         echo "<br>";
//     echo is_string($_POST['tipo_beneficio']);
//     if (is_string($_POST['tipo_beneficio'])==false) {
//       echo "f";
//     }else {
//       echo "t";
//     }

    if (!empty($_POST['fecha_desde']) && $_POST['fecha_desde'] != '' && !empty($_POST['fecha_hasta']) && $_POST['fecha_hasta'] != '')
    {
      $fecha_solicitado = $_POST['fecha_desde'];
      $fecha_solicitado_hasta = $_POST['fecha_hasta'];
      $id = $_POST['id'];
      if ($_SESSION['perfil'] == 2) {
        $cedula_id = $_POST['cedula'];
      } else {
        $cedula_id = $_SESSION['cedula_empleado'];
      }
      $estado_solicitud = $_POST['estado'];
      $tipo_solicitud =  $_POST['tipo'];
      $rango = $_POST['rango'];

      include('../model/mod_conexion.php');
      $conexionPGSQL = new ConexionPGSQL();
      $pgconn = $conexionPGSQL->conectar();

      include('../model/mod_solicitud.php');
      $solicitud = new Solicitud();
      $consultar = $solicitud->filtrar_solicitudes ($fecha_solicitado,$fecha_solicitado_hasta,$id,$cedula_id,$estado_solicitud,$tipo_solicitud,$rango,$pgconn);

      if(!empty($consultar) && $consultar != '' && $consultar != false)
      {
        $json = json_encode($consultar);

           echo "<form name='datos'>";
           echo "<input type='hidden' name='rango' value='$rango'>";
           echo "<input type='hidden' name='consulta' value='$json'>";
           echo "</form>";
           echo "<script type='text/javascript'>
                   document.datos.method = 'POST';
                   document.datos.action = '../view/view_consulta_solicitudes_resultado.php';
                   document.datos.submit();
                 </script>";

      }else{
        ?>
            <script type="text/javascript">
              alert('No han sido encontrada solicitudes con los parametros enviados');
              window.location="../view/view_consulta_solicitudes.php";
              // window.history.back();
            </script>
        <?php
      }
    }else {
    ?>
        <script type="text/javascript">
          alert('Recuerde seleccionar un rango de fecha para proceder');
          window.location="../view/view_consulta_solicitudes.php";
          // window.history.back();
        </script>
    <?php
   }
?>
