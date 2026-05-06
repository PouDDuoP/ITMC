<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 1) {
    if($_POST){
      //echo "recibo algo POST";

      //recibo los datos y los decodifico con PHP
      $misDatosJSON = json_decode($_POST["consulta"]);
      $rango = $_POST["rango"];
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
    <script type="text/javascript">
      function verSolcitud(input){
        var form = input.id;
        if (form.value.length === 0 || form == '') {
          return false
        } else {
          var valida = confirm('seguro desea camibar el estado de la solicitud con id: ['+form.value+']');
          if (valida == true) {
            console.log(valida.value +"-----"+ form.value);
            // document.datos.method = "post";
            // document.datos.action = "../controller/con_consulta_empleado.php";
            // document.datos.submit();
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
      <form class="" name="datos" action="#" method="post">
        <table>
          <thead>
            <tr class="centro">
              <td>--</td>
              <td>id</td>
              <td>Nro CI del Solicitante</td>
              <td>Fecha Solicitado</td>
              <td>Descripcion</td>
              <td>Tipo de solicitud</td>
              <td>Estado de Solicitud</td>
            </tr>
          </thead>
          <tbody>
          <?php
          $i = 0;
            foreach ($misDatosJSON as $key => $subArry[$i]) {
              foreach ($subArry[$i] as $keyID => $valueID) {
              }
          ?>
              <tr>
                <td>
  								<input type="radio" name="id" value="<?php echo $subArry[$i]->{'id'};?>">
   							</td>
                <td><?php echo $subArry[$i]->{'id'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'cedula_solicitante'};?>
                </td>
                <td>
                  <?php
                  $fecha = date_create($subArry[$i]->{'fecha_solicitud'});
                  echo date_format($fecha,'Y-m-d');
                  ?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'descripcion'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'tipon'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'estadon'};?>
                </td>
              </tr>
            <?php

              $i++;
            }
            ?>
          </tbody>
        </table>
        <div id="container-c"> </div>
        <!-- <button type="button" onclick="javascript: verSolicitud(document.datos);"/>Ver Solicitud</button> -->
      </form>
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
