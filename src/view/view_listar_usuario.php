<?php
session_start();
require_once '../inc/auth.php';
require_auth();
require_perfil([4, 3]);

    include_once('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    $status = TRUE;

    include_once ('../model/mod_perfil.php');
    $perfil = new Perfil;
    $consulta_perfil = $perfil->consultar_perfil_status ($status,$pgconn);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
    <script type="text/javascript">
    function consultar(input){
      if (input.rango.value.length === 0 || input.status.value.length === 0) {
        alert('Debe que escojer una cantidad para la consulta y seleccionar el status');
      } else {
          document.datos.method = "post";
          document.datos.action = "../controller/con_listar_usuarios.php";
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
      <form class="form" name='datos' action='#' method='post' autocomplete="off">
        <div class="empleado"> <h2>Listar Usuarios</h2> </div>
        <div class="contenedor">
          <div class="empleado">
            <select name="status">
              <option value="">Seleccione el status de usuario</option>
              <option value="t">Activo</option>
              <option value="f">Inactivo</option>
            </select>
          </div>

          <div class="empleado">
            <select name="perfil">
              <option value="">Seleccione el perfil</option>
              <?php while ($columna_perfil = pg_fetch_array($consulta_perfil)) { ?>
              <option value="<?php echo $columna_perfil['id']; ?>"><?php echo $columna_perfil['nombre']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="contenedor">
          <div class="empleado">
            <label>
              C&eacute;dula de empleado
            </label>
              <input type="text" required autocomplete="off"  onpaste="return false" onkeypress="return justNumbers(event);" maxlength="8" id="cedula" name="cedula" title="Ingrese la Cedula del Empleado" required />
          </div>

          <div class="empleado">
            <label>
              ID de usuario
            </label>
              <input type="text" required autocomplete="off"  onpaste="return false" onkeypress="return justNumbers(event);" maxlength="8" id="id" name="id" title="Ingrese el ID del Usuario" required />
          </div>
        </div>

        <div class="empleado">
          <select name="rango">
            <option value="">Seleccione el cantidad maxima que dese buscar:</option>
            <option value="10">10</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="300">300</option>
            <option value="ALL">Todos los registros</option>
          </select>
        </div>

        <button type="button" class="button button-block" onclick="javascript: consultar(document.datos);"/>Buscar</button>
      </form>
    </section>
    <?php include_once 'inc/script-lib.php'; ?>
  </body>
</html>

