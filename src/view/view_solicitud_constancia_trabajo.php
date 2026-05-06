<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] > 0) {
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
    <script type="text/javascript">
    function enviar(input){
      if (input.cedula.value.length === 0 || input.tipo_solicitud.value.length === 0 ||
          input.constancias.value.length === 0 ||
          input.descripcion.value.length === 0 ) {
        alert('Falto algun campo por rellenar');
        return (false);
      } else {
          document.datos.method = "post";
          document.datos.action = "../controller/con_crear_solicitud.php";
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
      <div class="empleado">  <h2>Constacia de Trabajo</h2></div>
        <div class="contenedor">
          <div class="empleado">
                C&eacute;dula del solicitante
              <input type="text" autocomplete="off" maxlength="8" id="cedula" name="cedula" title="Ingrese la Cedula del Empleado" value = "<?=$_SESSION['cedula_empleado']?>" readonly="readonly" disabled/>
          </div>
          <div class="empleado">
                Tipo Solicitud de solicitud
              <input type="text" autocomplete="off" maxlength="8" id="solicitud" name="solicitud" title="Tipo de solicitud" value = "Constacia de Trabajo" readonly="readonly" disabled/>
              <input type="hidden" autocomplete="off" maxlength="1" id="tipo_solicitud" name="tipo_solicitud" readonly="readonly" value="2"/>
          </div>
        </div>
        <div class="empleado">
            <select name="constancias">
              <option value="">Seleccione su tipo de Constancia</option>
              <option value="1">Integral</option>
              <option value="2">B&aacute;sica</option>
            </select>
        </div>
        <div class="empleado">
          <textarea name="descripcion" rows="5" cols="80" maxlength="200" id="descripcion"  placeholder="Indicar con no mas 200 caracteres a que se debe la solicitud" required></textarea>
        </div>
        <button type="button" class="button button-block" onclick="javascript: enviar(document.datos);"/>Enviar Solicitud</button>
      </form>
    </section>
    <?php include_once 'inc/script-lib.php'; ?>
  </body>
</html>
<?php
  }else {
    ?>
      <script type="text/javascript">
        alert('perfil '+<?php $_SESSION['perfil'] ?>+' no esta registrado');
          window.location="../index.php";
      </script>
    <?php
  }
}else {
  header('location: ../index.php');
  session_destroy();
}
?>
