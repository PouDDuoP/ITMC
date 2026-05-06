<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2) {
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
  </head>
  <body>
    <header id="header">
      <?php include_once 'inc/header.php'; ?>
      <script type="text/javascript">
      // $(function() {
      //
      //   $("#fecha_ingreso").datepicker({
      //     changeMonth: true,
      //     changeYear: true,
      //     altformat: 'ddmmyy',
      //     dateFormat: 'dd/mm/yy',
      //     // yearRange: '2017:2012',
      //     showOn: "button",
      //     buttonImage: "imagenes/calendar.gif",
      //     buttonImageOnly: true,
      //     minDate: "-100Y", maxDate: 0,
      //     // mindate: new Date(2017, 1 - 1, 1),
      //     // maxdate: new Date(),
      //     numberOfMonths: 3,
      //     dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
      //     monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr','May', 'Jun', 'Jul', 'Ago','Sep', 'Oct', 'Nov', 'Dic'] ,
      //     monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril','Mayo', 'Junio', 'Julio', 'Agosto','Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] ,
      //     onSelect: function( selectedDate ) {
      //       $( "#hasta" ).datepicker( "option", "minDate", selectedDate );
      //     }
      //   });
      // });
      function enviar(input){
        if (input.nombre.value.length === 0 || input.cedula.value.length === 0 ||
            input.apellido.value.length === 0 || input.fecha_ingreso.value.length === 0 ||
            input.cargo.value.length === 0 || input.departamento.value.length === 0 ||
            input.ext_telf.value.length === 0 || input.nro_telf.value.length === 0 ||
            input.sueldo.value.length === 0 || input.email.value.length === 0) {
          alert('Falto algun campo por rellenar');
          return (false);
        } else {
            document.datos.method = "post";
            document.datos.action = "../controller/con_registrar_empleado.php";
            document.datos.submit();
        }
    	}
      </script>
    </header>
    <?php include_once 'inc/nav.php'; ?>
    <form class="form" name="datos" autocomplete="off">
      <div class="empleado"> <h2>Registro de Empleado</h2> </div>
        <div class="empleado">
            <label>
              Nombres<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" onkeypress="javascript: return justLetters(event);" maxlength="40" id="nombre" name="nombre" title="Se Necesita los Nombres del Empleado" required />
        </div>

        <div class="empleado">
            <label>
              Apellidos<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" onkeypress="return justLetters(event);" maxlength="40" id="apellido" name="apellido" title="Se Necesita los Apellidos del Empleado" required/>
        </div>

        <div class="contenedor">
          <div class="empleado">
              <label>
                C&eacute;dula<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" onkeypress="return justNumbers(event);" maxlength="8" id="cedula" name="cedula" title="Ingrese la Cedula del Empleado" required />
          </div>

          <div class="empleado">
              <label>
               <span class="req"></span>
              </label>
              <input type="date" required autocomplete="off" id="fecha_ingreso" name="fecha_ingreso" title="Ingrese la Fecha de Ingreso del Emplado" data-provide="datepicker" mindate="2000-01-01" required />
          </div>
        </div>

        <!-- <div class="input-group date" data-provide="datepicker">
            <input type="text" class="form-control">
            <div class="input-group-addon">
              <span class="glyphicon glyphicon-th"></span>
            </div>
        </div> -->

        <!-- Verificar y hacer la relacion entre cargo y departamento -->

        <div class="contenedor">
          <div class="empleado">
            <select name="departamento" required>
              <option value="">Departamento:</option>
              <option value="1">DESARROLLO WEB</option>
              <option value="2">ADMINISTRACION</option>
            </select>
          </div>

          <div class="empleado">
            <select name="cargo" required>
              <option value="">Cargo:</option>
              <option value="1">DESARROLLADOR WEB</option>
              <option value="2">ADMINISTRADOR CONTABLE</option>
            </select>
          </div>          
        </div>

        <div class="contenedor">
          <div class="empleado">
              <label>
                Extensi&oacute;n<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" onkeypress="return justNumbers(event);" maxlength="4" id="ext_telf" name="ext_telf" title="Ingrese el Numero de Extesion del Empleado" />
          </div>
          <div class="empleado">
              <label>
                N&uacute;mero Telefonico<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" onkeypress="return justNumbers(event);" maxlength="7" id="nro_telf" name="nro_telf" title="Ingrese el Numero Telefonico del Empleado" required />
          </div>
        </div>

        <div class="empleado">
            <label>
              Sueldo Bs.<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" onkeypress="javascript: return justNumbers(event);" id="sueldo" name="sueldo" title="Suministre sueldo actual" required />
        </div>

        <div class="empleado">
          <label>
              Correo Electronico<span class="req">*</span>
          </label>
          <input type="email" required autocomplete="off" id="email" name="email" title="Ingrese el Correo Electronico del Empleado" required />
        </div>

        <button type="button" class="button button-block" onclick="javascript: enviar(document.datos)"/>Registrar</button>
    </form>
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
