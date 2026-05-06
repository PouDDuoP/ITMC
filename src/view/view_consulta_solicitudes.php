<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 1) {

    include_once('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    $status = TRUE;

    include_once ('../model/mod_tipo_solicitud.php');
    $tipo_solicitud = new TipoSolicitud;
    $consulta_tipo = $tipo_solicitud->consultar_tipo_solicitud($status,$pgconn);

    include_once ('../model/mod_estado_solicitud.php');
    $estado_solicitud = new EstadoSolicitud;
    $consulta_estado = $estado_solicitud->consultar_estado_solicitud($status,$pgconn);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
    <script type="text/javascript">
      function consultar(input){
        var form = input.rango.value;
        if (input.fecha_desde.value.length != 0 && input.fecha_hasta.value.length != 0) {
          document.datos.method = "post";
          document.datos.action = "../controller/con_consulta_solicitudes.php";
          document.datos.submit();
        } else {
          alert('Debe que escojer un rango de fecha');
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
        <div class="empleado"> <h2>Consulta de solicitudes</h2> </div>
        <div class="contenedor">
          <div class="empleado">
              <label>
                ID de la Solicitud
              </label>
              <input type="text" required autocomplete="off" onkeypress="return justNumbers(event);" maxlength="8" id="id" name="id" title="Ingrese la Cedula del Empleado" required />
          </div>
          <div class="empleado">
              <?php if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2) {?>
              <label>
                C&eacute;dula de empleado
              </label>
                <input type="text" required autocomplete="off" onkeypress="return justNumbers(event);" maxlength="8" id="cedula" name="cedula" title="Ingrese la Cedula del Empleado" required />
              <?php } else { ?>
                <label>
                  Mis Solicitudes - C.I: [<?php echo $_SESSION['cedula_empleado']?>]
                </label>
                <input type="hidden" required autocomplete="off" onkeypress="return justNumbers(event);" maxlength="8" id="cedula" name="cedula" value="<?php echo $_SESSION['cedula_empleado']?>" title="Cedula del Empleado" readonly="readonly" required />
              <?php } ?>
          </div>
        </div>

        <div class="contenedor">
          <!-- <p>Fecha desde</p> -->
          <div class="empleado">
            <input type="date" required autocomplete="off" id="fecha_desde" name="fecha_desde" title="Ingrese la Fecha desde donde quere Buscar" data-provide="datepicker" mindate="2000-01-01" required />
          </div>
          <!-- <p>Fecha hasta</p> -->
          <div class="empleado">
            <input type="date" required autocomplete="off" id="fecha_hasta" name="fecha_hasta" title="Ingrese la Fecha hasta donde quere Buscar" data-provide="datepicker" mindate="2000-01-01" required />
          </div>
        </div>
        
        <div class="contenedor">
          <div class="empleado">
            <select name="estado">
              <option value="">Seleccione el estado de la(s) solicitud(es)</option>
              <?php while ($columna_estado = pg_fetch_array($consulta_estado)) { ?>
              <option value="<?php echo $columna_estado['id']; ?>"><?php echo $columna_estado['nombre']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="empleado">
            <select name="tipo">
              <option value="">Seleccione el tipo de solicitud</option>
              <?php while ($columna_tipo = pg_fetch_array($consulta_tipo)) { ?>
              <option value="<?php echo $columna_tipo['id']; ?>"><?php echo $columna_tipo['nombre']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="empleado">
          <select name="rango">
            <option value="0">Seleccione el cantidad maxima que dese buscar:</option>
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
<?php

  }else {
    header('location: view_menu.php');
  }
}else {
  header('location: ../index.php');
  session_destroy();
}
?>
