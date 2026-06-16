<?php
session_start();

require_once '../inc/auth.php';
require_auth();
require_perfil([4, 2]);
    if (!empty($_POST['cedula']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['fecha_nacimiento']))
    {
      $cedula_id_hijo = '';
      $nivel_academico = '';
      if (!empty($_POST['cedula_hijo']) && $_POST['cedula_hijo'] != '') {
        $cedula_id_hijo = $_POST['cedula_hijo'];
      }
      if (!empty($_POST['nivel_academico']) && $_POST['nivel_academico'] != '') {
        $nivel_academico = $_POST['nivel_academico'];
      }

      $cedula_id = $_POST['cedula'];
      $nombre = $_POST['nombre'];
      $apellido = $_POST['apellido'];
      $fecha_nacimiento = $_POST['fecha_nacimiento'];

      include('../model/mod_conexion.php');
      $conexionPGSQL = new ConexionPGSQL();
      $pgconn = $conexionPGSQL->conectar();

      include('../model/mod_empleado_hijo.php');
      $hijo = new Hijo();
      // $consultar = $hijo->consultar_empleado_hijo ($cedula_id_hijo,$pgconn);

      include('../model/mod_empleado.php');
      $empleado = new Empleado();
      $consultarH = $empleado->consultar_empleado_cedula ($cedula_id,$pgconn);

      // if($consultar['id'] === $_POST['cedula_hijo'] ) {
        ?>
            <script type="text/javascript">
              // alert('El usuario ya existe porfavor verificar los datos ingresados');
              // window.location="../view/view_registrar_empleado.php";
            </script>
        <?php
      // }else {
        // echo '{'.$consultar['id'].'}<br>('.$cedula_id.')';
        $registar_hijo = $hijo->registrar_hijo ($cedula_id_hijo,$nombre,$apellido,$fecha_nacimiento,$nivel_academico,$pgconn);
        $registar_empelado_hijo = $hijo->registrar_empleado_hijo ($cedula_id,$cedula_id_hijo,$nombre,$apellido,$fecha_nacimiento,$nivel_academico,$pgconn);
        ?>
            <script type="text/javascript">
              alert('Hijo de empleado registrado con exito');
              window.location="../view/view_menu.php";
            </script>
        <?php
      // }
    }else {
    ?>
        <script type="text/javascript">
          alert('Recuerde rellenar campos obligatorios del formulario para poder registrar al hijo');
          window.history.go(-1);
        </script>
    <?php
   }
  
?>
