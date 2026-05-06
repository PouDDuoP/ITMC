<?php

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] >0) {
class Perfil
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

  function crear_perfil ($nombre,$descripcion,$status,$pgconn)
  {
    $querySQL = "INSERT INTO itmc.perfil_usuario(nombre, descripcion, status) VALUES ('$nombre','$descripcion',$status)";
        // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_perfil ($id,$status,$pgconn)
  {
    $querySQL = "SELECT * FROM itmc.perfil_usuario WHERE id = $id AND status = '$status'";
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

  function consultar_perfil_status ($status,$pgconn)
  {
    $querySQL = "SELECT * FROM itmc.perfil_usuario WHERE status = '$status'";
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
