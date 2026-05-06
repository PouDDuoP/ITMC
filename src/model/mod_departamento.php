<?php

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] >0) {
class Departamento
{
  private $id;
  private $nombre_empleado;
  private $descripcion;
  private $status;
  private $pgconn;

  function inicializar($id,$nombre_empleado,$descripcion,$status,$pgconn)
  {
    $this->id = $id;
    $this->nombre_empleado = $nombre_empleado;
    $this->descripcion = $descripcion;
    $this->status = $status;
    $this->pgconn = $pgconn;

  }

  function crear_departamento ($nombre,$descripcion,$status,$pgconn)
  {
    $querySQL = "INSERT INTO itmc.departamento(nombre, descripcion, status) VALUES ('$nombre','$descripcion',$status)";
        // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_departamento ($pgconn)
  {
    $querySQL = "SELECT * FROM itmc.departamento";
		$operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    if($operacion)
		{
			// $columna = pg_fetch_array($operacion);
			// return $columna;
      return $operacion;
		}
		 else
		{
			return false;
		}
  }

  function consultar_departamento_status ($status,$pgconn)
  {
    $querySQL = "SELECT * FROM itmc.departamento WHERE status = '$status'";
    // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    if($operacion)
		{
			// $columna = pg_fetch_array($operacion);
			// return $columna;
      return $operacion;
		}
		 else
		{
			return false;
		}
  }
}
    }else {
      header('location: ../view/view_menu.php');
      session_destroy();
    }
  }else {
  header('location: ../index.php');
  session_destroy();
  }

  ?>
