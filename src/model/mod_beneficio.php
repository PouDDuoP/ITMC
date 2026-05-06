<?php

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] >0) {
class Beneficio
{
  private $id;
  private $nombre;
  private $descripcion;
  private $status;
  private $pgconn;

  function inicializar($id,$nombre,$descripcion,$status,$pgconn)
  {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->descripcion = $descripcion;
    $this->status = $status;
    $this->pgconn = $pgconn;

  }

  function crear_beneficio ($nombre,$descripcion,$status,$pgconn)
  {
    $querySQL = "INSERT INTO itmc.tipo_beneficio(nombre, descripcion, status) VALUES ('$nombre','$descripcion',$status)";
        // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_beneficio ($status,$pgconn)
  {
    $querySQL = "SELECT * FROM itmc.tipo_beneficio WHERE status = '$status'";
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
