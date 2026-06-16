<?php

class Bitacora
{
  private $id;
  private $cedula_id;
  private $usuario_id;
  private $operacion;
  private $tabla;
  private $columna;
  private $valor_original;
  private $valor_nuevo;
  private $url;
  private $fecha;
  private $rango = 1;
  private $pgconn;

  function inicializar($cedula_id,$usuario_id,$operacion,$tabla,$columna,$valor_original,$valor_nuevo,$url,$fecha,$rango,$pgconn)
  {
  	$this->id = $id;
    $this->cedula_id = $cedula_id;
    $this->usuario = $usuario_id;
    $this->operacion = $operacion;
    $this->tabla = $tabla;
    $this->columna = $columna;
    $this->valor_original = $valor_original;
    $this->valor_nuevo = $valor_nuevo;
    $this->url = $url;
    $this->fecha = $fecha;
    $this->rango = $rango;
    $this->pgconn = $pgconn;

  }

  function registrar_bitacora ($cedula_id,$usuario_id,$operacion,$tabla,$columna,$valor_original,$valor_nuevo,$url,$fecha,$pgconn)
  {
    $querySQL = "SELECT itmc.sp_bitacora($1, $2, $3, $4, $5, $6, $7, $8, $9)";
		$operacion = pg_query_params($pgconn,$querySQL,array($cedula_id, $usuario_id, $operacion, $tabla, $columna, $valor_original, $valor_nuevo, $url, $fecha)) or die ("Consulta errónea: ".pg_last_error());
		return $operacion;
  }

  function consultar_bitacora ($rango,$pgconn)
  {
    $limit = "";
    $params = array();
    $paramIndex = 1;
    if (!empty($rango)) {
      $limit = "LIMIT $" . $paramIndex++;
      $params[] = (int)$rango;
    }elseif (is_string($limit)) {
      $limit = "";
    }else {
      $limit = "";
    }
    $querySQL = "SELECT * FROM itmc.bitacora ORDER BY id DESC $limit";
    $operacion = pg_query_params($pgconn,$querySQL,$params) or die ("Consulta errónea: ".pg_last_error());
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
