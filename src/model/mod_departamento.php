<?php

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
    $querySQL = "INSERT INTO itmc.departamento(nombre, descripcion, status) VALUES ($1, $2, $3)";
        // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($nombre, $descripcion, $status)) or die ("Consulta errónea: ".pg_last_error());

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
    $querySQL = "SELECT * FROM itmc.departamento WHERE status = $1";
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
