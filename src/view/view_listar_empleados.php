<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2 ) {

    include_once('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    $status = TRUE;

    include_once ('../model/mod_departamento.php');
    $departamento = new Departamento;
    $consulta_departamento = $departamento->consultar_departamento_status($status,$pgconn);
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
          if (input.monto_desde.value.length != 0 || input.monto_hasta.value.length != 0) {
            if (input.monto_desde.value > input.monto_hasta.value && input.monto_hasta.value < input.monto_desde.value) {
              alert('Recuerde que el sueldo desde debe ser menor al sueldo hasta');
            } else {
              document.datos.method = "post";
              document.datos.action = "../controller/con_listar_empleados.php";
              document.datos.submit();
            }
          } else {
            document.datos.method = "post";
            document.datos.action = "../controller/con_listar_empleados.php";
            document.datos.submit();
          }
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
        <div class="empleado"> <h2>Listar Empleados</h2> </div>

        <div class="contenedor">
          <div class="empleado">
            <select name="status">
              <option value="">Seleccione el status de empleado</option>
              <option value="t">Activo</option>
              <option value="f">Inactivo</option>
            </select>
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
        </div>

        <div class="contenedor">
          <div class="empleado">
            <label>
              C&eacute;dula de empleado
            </label>
              <input type="text" required autocomplete="off"  onpaste="return false" onkeypress="return justNumbers(event);" maxlength="8" id="cedula" name="cedula" title="Ingrese la Cedula del Empleado" required />
          </div>

          <div class="empleado">
            <select name="departamento">
              <option value="">Seleccione el depratamento</option>
              <?php while ($columna_departamento = pg_fetch_array($consulta_departamento)) { ?>
              <option value="<?php echo $columna_departamento['id']; ?>"><?php echo $columna_departamento['nombre']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="contenedor">
          <div class="empleado">
            <label>
              Sueldo desde
            </label>
            <input type="text" required autocomplete="off"  onpaste="return false" onkeypress="return justNumbers(event);" maxlength="15" id="monto_desde" name="monto_desde" title="Ingrese la Cedula del Empleado" required />
          </div>
          <div class="empleado">
            <label>
              Sueldo hasta
            </label>
            <input type="text" required autocomplete="off"  onpaste="return false" onkeypress="return justNumbers(event);" maxlength="15" id="monto_hasta" name="monto_hasta" title="Ingrese la Cedula del Empleado" required />
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
