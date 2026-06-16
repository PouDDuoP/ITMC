<?php
session_start();

// Include config if exists
if (file_exists('../config.php')) {
    include('../config.php');
}

require_once '../inc/auth.php';
require_auth();
require_perfil([4, 3]);
    if (!empty($_POST['id']) || $_POST['id'] != 0) {

    $id = $_POST['id'];

    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include('../model/mod_usuario.php');
    $usuario = new Usuario;
    $consultar = $usuario->consultar_usuario_id ($id,$pgconn);
    // $validar = pg_fetch_array($consultar);

      if(!empty($consultar) && $consultar != '' && $consultar != false)
      {

        // echo "[$id](".$validar['id'];
        // if($id === $validar['id']) {

          $arraydatos = array();
            while ($columna = pg_fetch_array($consultar)) {
              $arraydatos = $columna;
            }
            $json = json_encode($arraydatos);
            // $jsond = json_decode($json);
            // var_dump($jsond);

                    echo "<form name='datos'>";
                    echo "<input type='hidden' name='id' value='$id'>";
                    echo "<input type='hidden' name='consulta' value='$json'>";
                    echo "</form>";
                    echo "<script type='text/javascript'>
                            document.datos.method = 'POST';
                            document.datos.action = '../view/view_modificar_usuario.php';
                            document.datos.submit();
                          </script>";

              // } else {
              //   ?>
              //        <script type="text/javascript">
              //           alert('no se pudo ubicar el usuario en los registros');
              //           // window.location="view/view_consulta_usuario.php";
              //           window.history.back();
              //         </script>
              //    <?php
              // }
      }else{
        ?>
          <script type="text/javascript">
            alert('No existe el usuario con numero de id <?php echo "$id";?>');
            // window.location="view/view_consulta_usuario.php";
            window.history.back();
          </script>
        <?php
      }
    }else {
    ?>
        <script type="text/javascript">
          alert('Nro de usuario no encontrado');
          // window.location="view/view_consulta_usuario.php";
          window.history.back();
        </script>
    <?php
   }
  
?>
