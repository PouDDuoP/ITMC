<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2) {
    if($_POST){
       //echo "recibo algo POST";

       //recibo los datos y los decodifico con PHP
       $misDatosJSON = json_decode($_POST["consulta"]);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
  </head>
<script type="text/javascript">
function enviar(input){
  var form = input.cedula;
  if (form.value.length === 0 || form == '') {
    return false
  } else {
    var valida = confirm('seguro desea modificar al usuario con cedula de identida: '+form.value);
    if (valida == true) {
      // console.log(valida.value +"-----"+ form.value);
      document.datos.method = "post";
      document.datos.action = "../controller/con_consulta_empleado.php";
      document.datos.submit();
    }
  }
}
function habilitarOrInhabilitar(input){
  var form = input;
  if (form.cedula.value.length === 0 || form == ''){ //|| form.cedula_empleado.value.length === 0) {
    return false
  } else {
    // var valida = confirm('seguro desea modificar al usuario: '+form.cedula_empleado.value+' con perfil de: '+form.nombre_perfil.value);
    var valida = confirm('seguro desea Habilitar/Inhabilitar al usuario: '+form.cedula.value);
    if (valida == true) {
      console.log(valida.value +"-----"+ form.value);
      document.datos.method = "post";
      document.datos.action = "../controller/con_consulta_empleado_HabiOrInha.php";
      document.datos.submit();
    }
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
    <table>
      <thead>
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
				<form name="datos" action="#" method="post">
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
                <?php echo $misDatosJSON->{'cargon'};?>
              </td>
              <td>
                <?php echo $misDatosJSON->{'departamenton'};?>
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
					</form>
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
      <button type="button" onclick="javascript: enviar(document.datos);"/>Modificar</button>
      <button type="button" onclick="javascript: habilitarOrInhabilitar(document.datos);"/>Habilitar/Inhabilitar</button>
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
