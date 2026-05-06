<?php
session_start();
$_SESSION['cedula_empleado'];

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {


    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include('../model/mod_usuario.php');
    $usuario = new Usuario();
    $consultar_total = $usuario->estadistica_usuarios_total ($pgconn);

      if(pg_num_rows($consultar_total) > 0)
      {
        $consultar_perfil_1 = $usuario->estadistica_usuarios_perfil (1,$pgconn);
        $consultar_perfil_2 = $usuario->estadistica_usuarios_perfil (2,$pgconn);
        $consultar_perfil_3 = $usuario->estadistica_usuarios_perfil (3,$pgconn);
        $consultar_perfil_4 = $usuario->estadistica_usuarios_perfil (4,$pgconn);

        $total_registros = pg_num_rows($consultar_total);
        $resultado_perfil_1 = pg_num_rows($consultar_perfil_1);
        $resultado_perfil_2 = pg_num_rows($consultar_perfil_2);
        $resultado_perfil_3 = pg_num_rows($consultar_perfil_3);
        $resultado_perfil_4 = pg_num_rows($consultar_perfil_4);

        $porcentaje_perfil_1 = ($resultado_perfil_1*100)/$total_registros;
        $porcentaje_perfil_2 = ($resultado_perfil_2*100)/$total_registros;
        $porcentaje_perfil_3 = ($resultado_perfil_3*100)/$total_registros;
        $porcentaje_perfil_4 = ($resultado_perfil_4*100)/$total_registros;
// echo "$porcentaje_perfil_1---$porcentaje_perfil_2,,, $porcentaje_perfil_3------$porcentaje_perfil_4";


          echo "<form name='datos'>";
          echo "<input type='hidden' name='universo' value='$total_registros'>";
          echo "<input type='hidden' name='resultado_1' value='$resultado_perfil_1'>";
          echo "<input type='hidden' name='resultado_2' value='$resultado_perfil_2'>";
          echo "<input type='hidden' name='resultado_3' value='$resultado_perfil_3'>";
          echo "<input type='hidden' name='resultado_4' value='$resultado_perfil_4'>";
          echo "<input type='hidden' name='porcentaje_1' value='$porcentaje_perfil_1'>";
          echo "<input type='hidden' name='porcentaje_2' value='$porcentaje_perfil_2'>";
          echo "<input type='hidden' name='porcentaje_3' value='$porcentaje_perfil_3'>";
          echo "<input type='hidden' name='porcentaje_4' value='$porcentaje_perfil_4'>";
          echo "</form>";
          echo "<script type='text/javascript'>
                  document.datos.method = 'POST';
                  document.datos.action = '../view/view_usuarios_perfiles_resultado.php';
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
