<?php
session_start();
require_once '../inc/auth.php';
require_auth();
require_perfil([4, 2]);
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
    <script type="text/javascript">
    function click(){
      if(event.button==2){
        alert('Opcion no Permitida');
      }
    }
    document.onmousedown=click;
    function inhabilitar(){
        alert ("Opcion no Permitida");
        return false;
    }
    document.oncontextmenu=inhabilitar;
    document.onkeypress = inhabilitar;
    document.onkeydown=inhabilitar;
    </script>
  </head>
  <body>
    <header id="header">
      <?php include_once 'inc/header.php'; ?>
    </header>
    <section>
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
        <tbody>
        <?php
        $rango = '';
        $rango = $_GET['rango'];
          include('../model/mod_conexion.php');
          $conexionPGSQL = new ConexionPGSQL();
          $pgconn = $conexionPGSQL->conectar();

          include('../model/mod_empleado.php');
          $empleado = new Empleado();
          $consultar = $empleado->consultar_empleados ($rango,$pgconn);

          // $columna = pg_fetch_array($consultar);
        while($columna = pg_fetch_array($consultar)) {
        ?>
            <tr>
              <td><?php echo $columna['id'];?>
              </td>
              <td>
                <?php echo $columna['nombre'];?>
              </td>
              <td>
                <?php echo $columna['apellido'];?>
              </td>
              <td>
                <?php
                $fecha = date_create($columna['fecha_ingreso']);
                echo date_format($fecha,'Y-m-d');
                ?>
              </td>
              <td>
                <?php echo $columna['cargo'] ;?>
              </td>
              <td>
                <?php echo $columna['departamento'];?>
              </td>
              <td>
                <?php echo $columna['email'];?>
              </td>
              <td>
                <?php
                echo $columna['ext_telefono'].'-'.$columna['nro_telefono'];?>
              </td>
              <td>
                <?php echo $columna['sueldo'];?>
              </td>
              <td>
                <?php
                if ($columna['status'] == 't')
                  echo "habilitado";
                else {
                  echo "inhabilitado";
                }
                ?>
              </td>

            </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
  </body>
</html>
<script type="text/javascript">
  window.print();
</script>

