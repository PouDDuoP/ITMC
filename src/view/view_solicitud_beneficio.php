<?php
session_start();
require_once '../inc/auth.php';
require_auth();
require_perfil();

    // require_once('../controller/con_consultar_beneficio.php');
    // $misDatosJSON = json_decode($_POST["consulta"]);

    // NOTA VERIFICAR EL con_consultar_beneficio.php para hacer funcionar el json

    $status = TRUE;

    include_once('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include_once('../model/mod_beneficio.php');
    $beneficio = new Beneficio();
    $consultar = $beneficio->consultar_beneficio ($status,$pgconn);

    // $fecha_actual = date('Y-m-d');
    // $fecha_dada = '1990-05-12 00:00:00';
    // $resta = $fecha_actual-$fecha_dada;
    // echo "$resta";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
    <script type="text/javascript">
    function enviar(input){
      if (input.tipo_beneficio.value.length === 0 ) {
        alert('Recuerde seleccionar el tipo de beneficio a solicitar');
        return (false);
      } else {
          document.datos.method = "post";
          document.datos.action = "../controller/con_consulta_solicitud_beneficio.php";
          document.datos.submit();
      }
    }
    </script>
  </head>
  <body>
    <header id="header">
      <?php include_once 'inc/header.php'; ?>
    </header>
    <?php include_once 'inc/nav.php'; ?>
    <section>
      <form class="form" name="datos" autocomplete="off">
      <div class="empleado">  <h2>Beneficios por hijo(s)</h2></div>
          <div class="empleado">
              <select name="tipo_beneficio">
                <option value="">Seleccione el tipo de beneficio</option>
                <?php while ($columna = pg_fetch_array($consultar)) { ?>
                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?></option>
                <?php } ?>
              </select>
          </div>

        <button type="button" class="button button-block" onclick="javascript: enviar(document.datos);"/>Enviar Solicitud</button>
      </form>
    </section>
    <?php include_once 'inc/script-lib.php'; ?>
  </body>
</html>
