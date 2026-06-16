<?php


class Solicitud
{
  private $id;
  private $cedula_id;
  private $fecha_solicitado;
  private $fecha_solicitado_hasta;
  private $descripcion;
  private $tipo_solicitud;
  private $estado_solicitud;
  private $departamento;
  private $rango = 1;
  private $pgconn;

  function inicializar($id,$cedula_id,$fecha_solicitado,$descripcion,$tipo_solicitud,$fecha_solicitado_hasta,$estado_solicitud,$departamento,$rango,$pgconn)
  {
    $this->id = $id;
    $this->cedula_id = $cedula_id;
    $this->fecha_solicitado = $fecha_solicitado;
    $this->fecha_solicitado_hasta = $fecha_solicitado_hasta;
    $this->descripcion = $descripcion;
    $this->tipo_solicitud  = $tipo_solicitud;
    $this->estado_solicitud = $estado_solicitud;
    $this->departamento= $departamento;
    $this->rango = $rango;
    $this->pgconn = $pgconn;

  }

  function crear_solicitud ($fecha_solicitado,$cedula_id,$descripcion,$tipo_solicitud,$estado_solicitud,$departamento,$pgconn)
  {
    $querySQL = "INSERT INTO itmc.solicitud(fecha_solicitud, cedula_solicitante, descripcion, tipo_solicitud,estado_solicitud, departamento)VALUES ($1, $2, $3, $4, $5, $6)";
        // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($fecha_solicitado, $cedula_id, $descripcion, $tipo_solicitud, $estado_solicitud, $departamento)) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_solicitud ($rango,$pgconn)
  {
    $limit = "";
    $lparams = array();
    if (!empty($rango)) {
      $limit = "LIMIT $1";
      $lparams = array((int)$rango);
    }else {
      $limit = "";
    }
    $querySQL = "SELECT * FROM itmc.solicitud $limit";
    $operacion = pg_query_params($pgconn,$querySQL,$lparams) or die ("Consulta errónea: ".pg_last_error());
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

  function consultar_solicitud_fecha ($cedula_id,$fecha_solicitado,$tipo_solicitud,$pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.solicitud WHERE cedula_solicitante = $1 AND TO_CHAR(fecha_solicitud, 'YYYY-MM') = $2 AND tipo_solicitud = $3 GROUP BY id";
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id, $fecha_solicitado, $tipo_solicitud)) or die ("Consulta errónea: ".pg_last_error());
    // echo "$querySQL";
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

  function actualizar_solicitud ($departamento,$estado_solicitud,$pgconn)
  {
    $set_parts = array();
    $uparams = array();
    if (!empty($departamento)) {
      $set_parts[] = "departamento=$" . (count($uparams) + 1);
      $uparams[] = $departamento;
    }
    $set_parts[] = "estado_solicitud=$" . (count($uparams) + 1);
    $uparams[] = $estado_solicitud;
    $set_str = implode(", ", $set_parts);
    $querySQL = "UPDATE itmc.solicitud SET $set_str WHERE id=$" . (count($uparams) + 1);
    $uparams[] = $id;
    // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,$uparams) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		} else {
			return "nok";
		}
  }

  function filtrar_solicitudes ($fecha_solicitado,$fecha_solicitado_hasta,$id,$cedula_id,$estado_solicitud,$tipo_solicitud,$rango,$pgconn)
  {
    $conditions = array();
    $fparams = array();
    $paramIndex = 1;

    if (!empty($fecha_solicitado) && !empty($fecha_solicitado_hasta)) {
      $conditions[] = "fecha_solicitud BETWEEN $" . $paramIndex++ . " AND $" . $paramIndex++;
      $fparams[] = $fecha_solicitado . " 00:00:00";
      $fparams[] = $fecha_solicitado_hasta . " 24:00:00";
    }
    if (!empty($id)) {
      $conditions[] = "s.id = $" . $paramIndex++;
      $fparams[] = $id;
    }
    if (!empty($cedula_id)) {
      $conditions[] = "s.cedula_solicitante = $" . $paramIndex++;
      $fparams[] = $cedula_id;
    }
    if (!empty($estado_solicitud)) {
      $conditions[] = "s.estado_solicitud = $" . $paramIndex++;
      $fparams[] = $estado_solicitud;
    }
    if (!empty($tipo_solicitud)) {
      $conditions[] = "s.tipo_solicitud = $" . $paramIndex++;
      $fparams[] = $tipo_solicitud;
    }

    $where = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

    $limit = "";
    if (!empty($rango) && $rango > 0) {
      $limit = "LIMIT $" . $paramIndex++;
      $fparams[] = (int)$rango;
    }elseif ($rango == 'ALL') {
      $limit = "";
    }else {
      $limit = "LIMIT 0";
    }

    $querySQL = "SELECT s.*,es.nombre AS estadon,ts.nombre AS tipon FROM itmc.solicitud AS s LEFT JOIN itmc.estado_solicitud AS es ON s.estado_solicitud = es.id LEFT JOIN itmc.tipo_solicitud AS ts ON s.tipo_solicitud = ts.id $where $limit";
    // echo $querySQL;
    $operacion = pg_query_params($pgconn,$querySQL,$fparams) or die ("Consulta errónea: ".pg_last_error());

    $arraydatos = array();
    $i = 0;
      while ($columna = pg_fetch_array($operacion)) {
          $arraydatos[$i] = $columna;
          $i++;
      }

    if(!empty($arraydatos) && $arraydatos != '')
		{
			// $columna = pg_fetch_array($operacion);
			// return $columna;
      return $arraydatos;
		}
		 else
		{
			return false;
		}
  }

}

?>
