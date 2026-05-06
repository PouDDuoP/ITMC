<?php
session_start();
$_SESSION['cedula_empleado'];

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {

    $rango = $_POST['rango'];
    $cedula_id = $_POST['cedula'];
    $id = $_POST['id'];
    $perfil = $_POST['perfil'];
    $status  = $_POST['status'];

    if (!empty($rango) || $rango != "" && !empty($status) || $status != "") {

    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include('../model/mod_usuario.php');
    $usuario = new Usuario();
    $consultar = $usuario->filtrar_usuarios ($id,$cedula_id,$perfil,$status,$rango,$pgconn);

      if(!empty($consultar) && $consultar != '' && $consultar != false)
      {
        $arraydatos = array();
        $i = 0;
          while ($columna = pg_fetch_array($consultar)) {
            $arraydatos[$i] = $columna;
            $i++;
          }
          $json = json_encode($arraydatos);
          // $json = json_encode($arraydatos,JSON_UNESCAPED_UNICODE);
          //
          //
          // $fh = fopen("consulta.json", 'w');
          //   fwrite($fh, $json);
          //   fclose($fh);

          // echo "$json";
          echo "<form name='datos'>";
          echo "<input type='hidden' name='consulta' value='$json'>";
          echo "<input type='hidden' name='rango' value='$rango'>";
          echo "</form>";
          echo "<script type='text/javascript'>
                  document.datos.method = 'POST';
                  document.datos.action = '../view/view_listar_usuarios_resultado.php';
                  document.datos.submit();
                </script>";
      }else{
        echo "Error en la consulta a la base de Datos"."<br>";
      }
    } else {
      ?>
          <script type="text/javascript">
            alert('recuerde seleccionar rango y status para realizar la busqueda');
            window.location="../view/view_listar_usuario.php";
          </script>
      <?php
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
