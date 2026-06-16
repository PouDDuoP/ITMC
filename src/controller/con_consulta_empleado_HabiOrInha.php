<?php
session_start();

// Include config if exists
if (file_exists('../config.php')) {
    include('../config.php');
}

require_once '../inc/auth.php';
require_auth();
require_perfil([4, 3]);
    if (!empty($_POST['cedula']) || $_POST['cedula'] != 0) {

    $cedula_id = $_POST['cedula'];

    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include('../model/mod_empleado.php');
    $empleado = new Empleado;
    $consultar = $empleado->consultar_empleado ($cedula_id,$pgconn);

      if(!empty($consultar) && $consultar != '' && $consultar != false)
      {

          $arraydatos = array();
            while ($columna = pg_fetch_array($consultar)) {
              $arraydatos = $columna;
            }
            $json = json_encode($arraydatos);

                    echo "<form name='datos'>";
                    echo "<input type='hidden' name='cedula' value='$cedula_id'>";
                    echo "<input type='hidden' name='consulta' value='$json'>";
                    echo "</form>";
                    echo "<script type='text/javascript'>
                            document.datos.method = 'POST';
                             document.datos.action = '../view/view_HabiOrInha_empleado.php';
                            document.datos.submit();
                          </script>";
      }else{
        ?>
          <script type="text/javascript">
            alert('No existe el usuario con numero de cedula <?php echo "$cedula_id";?>');
            // window.location="view/view_consulta_empleado.php";
            window.history.back();
          </script>
        <?php
      }
    }else {
    ?>
        <script type="text/javascript">
          alert('Nro de usuario no encontrado');
          // window.location="view/view_consulta_empleado.php";
          window.history.back();
        </script>
    <?php
   }
  else {
        <?php
    }
?>
