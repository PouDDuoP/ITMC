<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2 ) {
    if($_POST){
       //echo "recibo algo POST";

       //recibo los datos y los decodifico con PHP
       $misDatosJSON = json_decode($_POST["consulta"]);
       $misDatosJSONH = '';
       $misDatosJSONH = json_decode($_POST["consultaH"]);
       date_default_timezone_set('America/La_Paz');
       $fecha_actual = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
  </head>
<script type="text/javascript">
function enviar(input){
  if (input.nombre.value.length === 0 || input.cedula.value.length === 0 ||
      input.apellido.value.length === 0 ||  input.fecha_nacimiento.value.length === 0) { //||
      // input.cedula_hijo.value.length === 0 || input.nivel_academico.value.length === 0
    alert('Falto algun campo por rellenar');
    return (false);
  } else {
      // console.log(valida.value +"-----"+ form.value);
      document.datos.method = "post";
      document.datos.action = "../controller/con_registrar_empleado_hijo.php";
      document.datos.submit();
  }
}
</script>
<style type="text/css">


/* Datagrid */
	body {
  font: normal medium/1.4 sans-serif;
  background: rgba(188,232,245,1);
background: -moz-linear-gradient(top, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(188,232,245,1)), color-stop(100%, rgba(247,213,172,1)));
background: -webkit-linear-gradient(top, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
background: -o-linear-gradient(top, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
background: -ms-linear-gradient(top, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
background: linear-gradient(to bottom, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bce8f5', endColorstr='#f7d5ac', GradientType=0 );}
table {
  border-collapse: collapse;
  width: 100%;
}
th, td {
  padding: 0.25rem;
  border: 1px solid #ccc;
}
tbody tr:nth-child(odd) {
  background: #eee;
}
.centro{
  padding: 0.5rem;
  background: #484848 ;
  color: white;
  text-align: center;
  font-size: 21px;

}

#cuadro{
	width: 90%;
	background: #F8F8F8 ;
	padding: 25px;
	margin: 5px auto;
	border: 3px solid #D8D8D8;
}
#titulo{
	width: 100%;
	background: #282828;
	color:white;

}
</style>
</head>
<body>
  <header id="header">
    <?php include_once 'inc/header.php'; ?>
  </header>
  <?php include_once 'inc/nav.php'; ?>
  <section>
		<div class="form-group">
    <form name="datos" action="#" method="post">
    <table>
      <thead>
        <tr class="centro">
          <td>Datos del Empleado</td>
        </tr>
        <tr class="centro">
          <td>Cedula</td>
          <td>Nombres</td>
          <td>Apellidos</td>
          <td>Fecha de Ingreso</td>
          <td>Cargo</td>
          <td>Departamento</td>
          <td>Correo Electronico</td>
          <td>Nro-Telefonico</td>
          <td>Sueldo</td>
          <td>Status</td>
        </tr>
      </thead>
      <tbody>
        <?php
        if(!empty($misDatosJSON) && $misDatosJSON->{'id'} !='') {
        ?>
            <tr>
								<input type="hidden" name="cedula" value="<?php echo $misDatosJSON->{'id'};?>">

              <td><?php echo $misDatosJSON->{'id'};?>
              </td>
              <td>
                <?php echo $misDatosJSON->{'nombre'};?>
              </td>
              <td>
                <?php echo $misDatosJSON->{'apellido'};?>
              </td>
              <td>
                <?php $fecha = date_create($misDatosJSON->{'fecha_ingreso'});
                echo date_format($fecha,'Y-m-d');
                ?>
              </td>
              <td>
                <?php echo $misDatosJSON->{'cargo'};?>
              </td>
              <td>
                <?php echo $misDatosJSON->{'departamento'};?>
              </td>
              <td>
                <?php echo $misDatosJSON->{'email'};?>
              </td>
              <td>
                <?php
                echo $misDatosJSON->{'ext_telefono'}.'-'.$misDatosJSON->{'nro_telefono'};?>
              </td>
              <td>
                <?php echo $misDatosJSON->{'sueldo'};?>
              </td>
              <td>
                <?php
                if ($misDatosJSON->{'status'} == 't')
                  echo "habilitado";
                else {
                  echo "inhabilitado";
                }
                ?>
              </td>
            </tr>
          <?php
        }else {
          ?>
            <script type="text/javascript">
              alert('No existe el empleado con numero de cedula '<?php echo "$cedula_id";?>);
              window.location="../view/view_consulta_empleado.php";
            </script>
          <?php
        }
          ?>
      </tbody>
    </table>
    <?php if (empty($misDatosJSONH) || $misDatosJSONH == '') { } else {?>
    <hr>
    <table>
      <thead>
        <tr class="centro">
          <td>Hijo Registrados</td>
        </tr>
        <tr class="centro">
          <td>Cedula de Hijo</td>
          <td>Nombres</td>
          <td>Apellidos</td>
          <td>Fecha de Nacimiento</td>
          <td>Edad</td>
          <td>nivel academico</td>
        </tr>
      </thead>
      <tbody>
      <?php
      $i = 0;
        foreach ($misDatosJSONH as $key => $subArry[$i]) {
          foreach ($subArry[$i] as $keyID => $valueID) {
          }
      ?>
          <tr>
            <td><?php echo $subArry[$i]->{'cedula_hijo'};?>
            </td>
            <td>
              <?php echo $subArry[$i]->{'nombre'};?>
            </td>
            <td>
              <?php echo $subArry[$i]->{'apellido'};?>
            </td>
            <td>
              <?php
              $fecha = date_create($subArry[$i]->{'fecha_nacimiento'});
              $nacido = date_format($fecha,'Y-m-d');
              echo $nacido;
              ?>
            </td>
             <td>
              <?php
              $fechaNacido = new DateTime($nacido);
              $fechaActual   = new DateTime($fecha_actual);

              $dateDiff  = $fechaNacido->diff($fechaActual);
              print $dateDiff->format("%Y Años y %m meses");
              ?>
            </td>
            <td>
              <?php echo $subArry[$i]->{'nivel_academico'};?>
            </td>
          </tr>
        <?php

          $i++;
        }
        ?>
      </tbody>
    </table>
    <?php }?>
    <hr>
    <table>
      <thead>
        <tr class="centro">
          <td>Registro de hijos</td>
        </tr>
        <tr class="centro">
          <td>Cedula de Hijo</td>
          <td>Nombres</td>
          <td>Apellidos</td>
          <td>Fecha de Nacimiento</td>
          <td>nivel academico</td>
        </tr>
      </thead>
      <tbody>
            <td>
              <input type="text" autocomplete="off" onkeypress="return justNumbers(event);" maxlength="8" id="cedula_hijo" name="cedula_hijo" title="Ingrese la Cedula del Hijo" />
            </td>
            <td>
              <input type="text" required autocomplete="off" onkeypress="javascript: return justLetters(event);" maxlength="40" id="nombre" name="nombre" title="Se Necesita los Nombres del Hijo" required />
            </td>
            <td>
              <input type="text" required autocomplete="off" onkeypress="return justLetters(event);" maxlength="40" id="apellido" name="apellido" title="Se Necesita los Apellidos del Hijo" required/>
            </td>
            <td>
              <input type="date" required autocomplete="off" id="fecha_nacimiento" name="fecha_nacimiento" title="Ingrese la Fecha de nacimiento del hijo" data-provide="datepicker" mindate="2000-01-01" required />
            </td>
            <td>
              <input type="text" autocomplete="off" maxlength="40" id="nivel_academico" name="nivel_academico" title="Nivel academico del hijo" />
            </td>
          </tr>
      </tbody>
    </table>
    </form>
    <hr>
    <button type="button" onclick="javascript: enviar(document.datos);"/>Registrar</button>
    </div>
  </section>
<?php include_once 'inc/script-lib.php'; ?>
</body>
</html>
<?php
    }else{
      ?>
          <script type="text/javascript">
            alert('no se ha resibido ningun parametro');
            window.location="../view/view_consulta_empleado.php";
          </script>
      <?php
    }
  }else {
    header('location: view_menu.php');
  }
}else {
  header('location: ../index.php');
  session_destroy();
}
?>
