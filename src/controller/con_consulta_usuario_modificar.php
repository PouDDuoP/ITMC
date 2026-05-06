<?php
session_start();

// Include config if exists
if (file_exists('../config.php')) {
    include('../config.php');
}

$_SESSION['cedula_empleado'];

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {
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
  }else {
    ?>
        <script type="text/javascript">
          alert('este modulo solo esta habilitado para usuario administrador');
          window.location="../view/view_menu.php";
        </script>
    <?php
  }
} else {
  header('Location: index.php');
  session_destroy();
}
?>
