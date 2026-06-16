<?php


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
    $querySQL = "INSERT INTO itmc.tipo_beneficio(nombre, descripcion, status) VALUES ($1, $2, $3)";
        // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($nombre, $descripcion, $status)) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_beneficio ($status,$pgconn)
  {
    $querySQL = "SELECT * FROM itmc.tipo_beneficio WHERE status = $1";
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
