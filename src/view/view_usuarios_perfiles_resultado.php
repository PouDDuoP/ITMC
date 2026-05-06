<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {
    if($_POST){
       //echo "recibo algo POST";

       //recibo los datos
       $universo = $_POST["universo"];
       $resultado_1 = $_POST["resultado_1"];
       $resultado_2 = $_POST["resultado_2"];
       $resultado_3 = $_POST["resultado_3"];
       $resultado_4 = $_POST["resultado_4"];
       $porcentaje_1 = $_POST["porcentaje_1"];
       $porcentaje_2 = $_POST["porcentaje_2"];
       $porcentaje_3 = $_POST["porcentaje_3"];
       $porcentaje_4 = $_POST["porcentaje_4"];
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
  </head>
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
            <td>100% de usuarios registrados</td>
            <td><?php echo number_format($porcentaje_1,2); ?>% usuarios con perfil de Empleado</td>
            <td><?php echo number_format($porcentaje_2,2); ?>% usuarios con perfil de Analista de Talento Humano</td>
            <td><?php echo number_format($porcentaje_3,2); ?>% usuarios con perfil de Analista de Sistemas</td>
            <td><?php echo number_format($porcentaje_4,2); ?>% usuarios con perfil de Administrador Del Sistema</td>
          </tr>
        </thead>
        <tbody>
        <?php
        if(!empty($universo) && !empty($resultado_1) && !empty($porcentaje_1)) {
        ?>
				<form name="datos" action="#" method="post">
            <tr>
              <td><?php echo $universo;?>
              </td>
              <td>
                <?php echo $resultado_1;?>
              </td>
              <td>
                <?php echo $resultado_2;?>
              </td>
              <td>
                <?php echo $resultado_3;?>
              </td>
              <td>
                <?php echo $resultado_4;?>
              </td>
            </tr>
					</form>
          <?php
        }else {
          ?>
            <script type="text/javascript">
              alert('Algun parametro a llegado vacio verificar la busqueda');
              window.location="../view/view_menu.php";
            </script>
          <?php
        }
          ?>
        </tbody>
      </table>
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
            window.location="../view/view_hijos_edad_comprendida.php";
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
