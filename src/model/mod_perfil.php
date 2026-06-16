<?php


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
    $querySQL = "INSERT INTO itmc.perfil_usuario(nombre, descripcion, status) VALUES ($1, $2, $3)";
        // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($nombre, $descripcion, $status)) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_perfil ($id,$status,$pgconn)
  {
    $querySQL = "SELECT * FROM itmc.perfil_usuario WHERE id = $1 AND status = $2";
    // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($id, $status)) or die ("Consulta errónea: ".pg_last_error());
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
    $querySQL = "SELECT * FROM itmc.perfil_usuario WHERE status = $1";
    // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($status)) or die ("Consulta errónea: ".pg_last_error());
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


?>
