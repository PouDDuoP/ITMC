<?php
session_start();
date_default_timezone_set('America/La_Paz');
$_SESSION['cedula_empleado'];

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] > 0)
  {
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



// NOTA: Verificar la resta de las fechas


    if (!empty($_POST['tipo_beneficio']) && $_POST['tipo_beneficio'] != '')
    {
      $cedula_id = $_SESSION['cedula_empleado'];
      $estado_solicitud = 1;
      $fecha_actual = date('Y-m-d');
      $tipo_beneficio = $_POST['tipo_beneficio'];



      include('../model/mod_conexion.php');
      $conexionPGSQL = new ConexionPGSQL();
      $pgconn = $conexionPGSQL->conectar();

      include('../model/mod_empleado_hijo.php');
      $hijo = new Hijo();
      $consultar = $hijo->consultar_empleado_hijo ($cedula_id,$pgconn);

      if(!empty($consultar) && $consultar != '' && $consultar != false)
      {

          switch ($tipo_beneficio) {
            case '1':
              $arraydatos = array();
              $i = 0;
              $j = 0;
                while ($columna = pg_fetch_array($consultar)) {
                  $edad = $fecha_actual-$columna['fecha_nacimiento'];
                  if ($edad > 5 && $edad < 16 ) {
                    $arraydatos[$i] = $columna;
                    $j++;
                  }
                  $i++;
                }
              $jsonH = json_encode($arraydatos);

              if ($j == 0) {
               ?>
               <script type="text/javascript">
                 alert('Sus hijos no estan en la edad comprendida para este beneficio');
                 window.location="../view/view_solicitud_beneficio.php";
                 // window.history.back();
               </script>
               <?php
               } else {
                 echo "<form name='datos'>";
                 echo "<input type='hidden' name='tipo_beneficio' value='$tipo_beneficio'>";
                 echo "<input type='hidden' name='consultaH' value='$jsonH'>";
                 echo "</form>";
                 echo "<script type='text/javascript'>
                         document.datos.method = 'POST';
                         document.datos.action = '../view/view_solicitud_beneficio_resultado.php';
                         document.datos.submit();
                       </script>";
               }
              break;
            case '2':
                $arraydatos = array();
                $i = 0;
                $j = 0;
                  while ($columna = pg_fetch_array($consultar)) {
                    $edad = $fecha_actual-$columna['fecha_nacimiento'];
                    if ($edad > 5 && $edad < 18 ) {
                      $arraydatos[$i] = $columna;
                      $j++;
                    }
                    $i++;
                  }
                $jsonH = json_encode($arraydatos);

                if ($j == 0) {
                 ?>
                 <script type="text/javascript">
                   alert('Sus hijos no estan en la edad comprendida para este beneficio');
                   window.location="../view/view_solicitud_beneficio.php";
                   // window.history.back();
                 </script>
                 <?php
                 } else {
                   echo "<form name='datos'>";
                   echo "<input type='hidden' name='tipo_beneficio' value='$tipo_beneficio'>";
                   echo "<input type='hidden' name='consultaH' value='$jsonH'>";
                   echo "</form>";
                   echo "<script type='text/javascript'>
                           document.datos.method = 'POST';
                           document.datos.action = '../view/view_solicitud_beneficio_resultado.php';
                           document.datos.submit();
                         </script>";
                 }
              break;
            case '3':
                $arraydatos = array();
                $i = 0;
                $j = 0;
                  while ($columna = pg_fetch_array($consultar)) {
                    $edad = 0;
                    $edad = $fecha_actual-$columna['fecha_nacimiento'];

                    if ($edad >=0 && $edad < 12) {
                      $arraydatos[$i] = $columna;
                      $j++;
                    }
                    $i++;
                  }
                $jsonH = json_encode($arraydatos);

                if ($j == 0) {
                 ?>
                 <script type="text/javascript">
                   alert('Sus hijos no estan en la edad comprendida para este beneficio');
                   window.location="../view/view_solicitud_beneficio.php";
                   // window.history.back();
                 </script>
                 <?php
                 } else {
                   echo "<form name='datos'>";
                   echo "<input type='hidden' name='tipo_beneficio' value='$tipo_beneficio'>";
                   echo "<input type='hidden' name='consultaH' value='$jsonH'>";
                   echo "</form>";
                   echo "<script type='text/javascript'>
                           document.datos.method = 'POST';
                           document.datos.action = '../view/view_solicitud_beneficio_resultado.php';
                           document.datos.submit();
                         </script>";
                 }
              break;
            case '4':
                $arraydatos = array();
                $i = 0;
                $j = 0;
                  while ($columna = pg_fetch_array($consultar)) {
                    $edad = $fecha_actual-$columna['fecha_nacimiento'];
                    if ($edad >0 && $edad < 6 ) {
                      $arraydatos[$i] = $columna;
                      $j++;
                    }
                    $i++;
                  }
                $jsonH = json_encode($arraydatos);

                if ($j == 0) {
                 ?>
                 <script type="text/javascript">
                   alert('Sus hijos no estan en la edad comprendida para este beneficio');
                   window.location="../view/view_solicitud_beneficio.php";
                   // window.history.back();
                 </script>
                 <?php
                 } else {
                   echo "<form name='datos'>";
                   echo "<input type='hidden' name='tipo_beneficio' value='$tipo_beneficio'>";
                   echo "<input type='hidden' name='consultaH' value='$jsonH'>";
                   echo "</form>";
                   echo "<script type='text/javascript'>
                           document.datos.method = 'POST';
                           document.datos.action = '../view/view_solicitud_beneficio_resultado.php';
                           document.datos.submit();
                         </script>";
                 }
              break;

            default:
              ?>
              <script type="text/javascript">
                alert('tipo de beneficio no reconocible');
                window.location="../view/view_solicitud_beneficio.php";
                // window.history.back();
              </script>
              <?php
              break;
          }

      }else{
        ?>
            <script type="text/javascript">
              alert('El usuario no posee hijos registrados en el sistema');
              window.location="../view/view_solicitud_beneficio.php";
              // window.history.back();
            </script>
        <?php
      }
    }else {
    ?>
        <script type="text/javascript">
          alert('Recuerde seleccionar tipo de beneficio para proceder');
          window.location="../view/view_solicitud_beneficio.php";
          // window.history.back();
        </script>
    <?php
   }
  }else {
    ?>
        <script type="text/javascript">
          alert('USted no posee un perfil valido');
          window.location="../view/view_menu.php";
        </script>
    <?php
  }
}else {
  header('location: ../index.php');
  session_destroy();
}
?>
