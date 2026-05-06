<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] > 0) {
    if($_POST){
       //echo "recibo algo POST";
      //  header('refresh 1: view_solicitud_beneficio_resultado.php');
       //recibo los datos y los decodifico con PHP
       $misDatosJSONH = json_decode($_POST["consultaH"]);
       $tipo_beneficio = $_POST["tipo_beneficio"];
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
  if (input.tipo_beneficio.value.length === 0 || input.id.value.length === 0) {
    alert('recuerde seleccionar el hijo al cual va dirigido el beneficio');
    return (false);
  } else {
      document.datos.method = "post";
      document.datos.action = "../controller/con_crear_solicitud_beneficio.php";
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
      <tr class="centro" style="background-color: #484848;">
        <td>Seleccione a el hijo para el cual va a realizar la solicitud</td>
      </tr>
    </table>
    <input type='hidden' name='tipo_beneficio' value='<?php echo $tipo_beneficio; ?>'>
    <table>
      <thead>
        <tr class="centro">
          <td>--</td>
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
            <td>
              <input type="radio" name="id" value="<?php echo $subArry[$i]->{'id'};?>">
            </td>
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
    </form>
    <hr>
    <button type="button" onclick="javascript: enviar(document.datos);"/>Solicitar</button>
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
