<?php


class TipoSolicitud
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

  function crear_tipo_solicitud ($nombre,$descripcion,$status,$pgconn)
  {
    $querySQL = "INSERT INTO itmc.tipo_solicitud(nombre, descripcion, status) VALUES ($1, $2, $3)";
        // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($nombre, $descripcion, $status)) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_tipo_solicitud ($status,$pgconn)
  {
    $querySQL = "SELECT * FROM itmc.tipo_solicitud WHERE status = $1";
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
