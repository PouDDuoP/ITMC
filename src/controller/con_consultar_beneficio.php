<?php
session_start();
require_once '../inc/auth.php';
require_auth();
require_perfil(4);

    $status = TRUE;

        include_once('../model/mod_conexion.php');
        $conexionPGSQL = new ConexionPGSQL();
        $pgconn = $conexionPGSQL->conectar();

        include_once('../model/mod_beneficio.php');
        $beneficio = new Beneficio();
        $consultar = $beneficio->consultar_beneficio ($status,$pgconn);

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
              echo "</form>";
              echo "<script type='text/javascript'>
                      document.datos.method = 'POST';
                      document.datos.action = '../view/view_solicitud_beneficio.php';
                      document.datos.submit();
                    </script>";
        }else {
          ?>
            <script type="text/javascript">
              alert('Eror al tratar de listar los beneficios');
              window.location="../view/view_menu.php";
            </script>
          <?php
          }
  

?>
