<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {
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
              <td>Id</td>
              <td>Cedula empleado</td>
              <td>Cod. Usuario</td>
              <td>Operacion Realizada</td>
              <td>Tabla</td>
              <td>Columna</td>
              <td>Valor Original</td>
              <td>Valor Nuevo</td>
              <td>URL</td>
              <td>Fecha de Modificacion</td>
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
                <td><?php echo $subArry[$i]->{'id'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'cedula_empleado'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'cod_usuario'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'cod_operacion'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'tabla'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'columna'};?>
                </td>
                <td>
                  <?php
                  echo $subArry[$i]->{'valor_original'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'valor_nuevo'};?>
                </td>
                <td>
                  <?php echo $subArry[$i]->{'url'};?>
                </td>
                </td>
                <td>
                  <?php
                  $fecha = date_create($subArry[$i]->{'fecha'});
                  echo date_format($fecha,'Y-m-d');
                  ?>
                </td>
              </tr>
            <?php
              $i++;
            }
            ?>
          </tbody>
        </table>
        <div id="container-c"></div>
        <button type="button" onClick="javascript: window.open('view_reporte_cambios_realizados.php?rango=<?php echo $rango;?>','reporte_empleados','scrollbars=yes, dependent=yes, top=100, left=100, resizable=1');" target="_blank"/>Imprimir</button>
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
