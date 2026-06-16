<?php
session_start();
require_once '../inc/auth.php';
require_auth();
require_perfil([4, 3]);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
    <script type="text/javascript">
      function consultar(input){
        if (input.fecha_desde.value.length === 0 || input.fecha_hasta.value.length === 0) {
          alert('Debe que escojer un valor');
        } else {
          if (input.fecha_desde.value > input.fecha_hasta.value || input.fecha_hasta.value < input.fecha_desde.value === 0) {
            alert('La fecha hasta debe ser mayor a la fecha desde');
          } else {
            document.datos.method = "post";
            document.datos.action = "../controller/con_hijos_edad_comprendida.php";
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
        <div class="empleado"> <h2>Generar estadisticas de hijos con edad comprendida</h2> </div>
        <div class="contenedor">
          <div class="empleado">
            <p>Fecha nacimiento desde</p>
            <input type="date" required autocomplete="off" id="fecha_desde" name="fecha_desde" title="Ingrese la Fecha desde donde quere Buscar" data-provide="datepicker" mindate="1980-01-01" required />
          </div>
          <div class="empleado">
            <p>Fecha nacimiento hasta</p>
            <input type="date" required autocomplete="off" id="fecha_hasta" name="fecha_hasta" title="Ingrese la Fecha hasta donde quere Buscar" data-provide="datepicker" mindate="1980--01-01" required />
          </div>
        </div>

        <button type="button" class="button button-block" onclick="javascript: consultar(document.datos);"/>Buscar</button>
      </form>
    </section>
    <?php include_once 'inc/script-lib.php'; ?>
  </body>
</html>

