<?php

class Beneficiario
{
  private $id;
  private $cedula_id;
  private $id_hijo;
  private $tipo_beneficio;
  private $fecha_solicitado;
  private $estado_solicitud;
  private $status;
  private $rango = 1;
  private $pgconn;

  function inicializar($id,$cedula_id,$id_hijo,$tipo_beneficio,$fecha_solicitado,$estado_solicitud,$status,$rango,$pgconn)
  {
    $this->id = $id;
    $this->cedula_id = $cedula_id;
    $this->id_hijo = $id_hijo;
    $this->tipo_beneficio = $tipo_beneficio;
    $this->fecha_solicitado  = $fecha_solicitado;
    $this->estado_solicitud = $estado_solicitud;
    $this->status = $status;
    $this->rango = $rango;
    $this->pgconn = $pgconn;

  }

  function crear_solicitud_beneficio ($cedula_id,$id_hijo,$tipo_beneficio,$fecha_solicitado,$estado_solicitud,$pgconn)
  {
    $querySQL = "INSERT INTO itmc.beneficiario (cedula_empleado, cod_hijo, tipo_beneficio, fecha_solicitud, estado_solicitud) VALUES ($1, $2, $3, $4, $5)";
        // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id, $id_hijo, $tipo_beneficio, $fecha_solicitado, $estado_solicitud)) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_solicitud_beneficio ($rango,$pgconn)
  {
    $limit = "";
    $lparams = array();
    if (!empty($rango)) {
      $limit = "LIMIT $1";
      $lparams = array((int)$rango);
    }else {
      $limit = "";
    }
    $querySQL = "SELECT * FROM itmc.beneficiario $limit";
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

  function consultar_solicitud_beneficio_anual ($cedula_id,$id_hijo,$fecha_solicitado,$tipo_beneficio,$pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.beneficiario WHERE cedula_empleado = $1 AND TO_CHAR(fecha_solicitud, 'YYYY') = $2 AND tipo_beneficio = $3 AND cod_hijo = $4 AND status = TRUE GROUP BY id";
    // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id, $fecha_solicitado, $tipo_beneficio, $id_hijo)) or die ("Consulta errónea: ".pg_last_error());
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

  function consultar_solicitud_beneficio_mensual ($cedula_id,$id_hijo,$fecha_solicitado,$tipo_beneficio,$pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.beneficiario WHERE cedula_empleado = $1 AND TO_CHAR(fecha_solicitud, 'YYYY-MM') = $2 AND tipo_beneficio = $3 AND cod_hijo = $4 AND status = TRUE GROUP BY id";
    // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id, $fecha_solicitado, $tipo_beneficio, $id_hijo)) or die ("Consulta errónea: ".pg_last_error());
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


  function actualizar_solicitud_beneficio ($id,$status,$estado_solicitud,$pgconn)
  {
    $set_parts = array();
    $uparams = array();
    if (!empty($status)) {
      $set_parts[] = "status=$" . (count($uparams) + 1);
      $uparams[] = $status;
    }
    $set_parts[] = "estado_solicitud=$" . (count($uparams) + 1);
    $uparams[] = $estado_solicitud;
    $set_str = implode(", ", $set_parts);
    $querySQL = "UPDATE itmc.beneficiario SET $set_str WHERE id=$" . (count($uparams) + 1);
    $uparams[] = $id;
    // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,$uparams) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function filtrar_solicitudes_beneficio ($fecha_solicitado,$fecha_solicitado_hasta,$id,$cedula_id,$cod_hijo,$status,$estado_solicitud,$tipo_beneficio,$rango,$pgconn)
  {
    $conditions = array();
    $fparams = array();
    $paramIndex = 1;

    if (!empty($fecha_solicitado) && !empty($fecha_solicitado_hasta)) {
      $conditions[] = "b.fecha_solicitud BETWEEN $" . $paramIndex++ . " AND $" . $paramIndex++;
      $fparams[] = $fecha_solicitado . " 00:00:00";
      $fparams[] = $fecha_solicitado_hasta . " 24:00:00";
    }
    if (!empty($id)) {
      $conditions[] = "b.id = $" . $paramIndex++;
      $fparams[] = $id;
    }
    if (!empty($cedula_id)) {
      $conditions[] = "b.cedula_empleado = $" . $paramIndex++;
      $fparams[] = $cedula_id;
    }
    if (!empty($cod_hijo)) {
      $conditions[] = "b.cod_hijo = $" . $paramIndex++;
      $fparams[] = $cod_hijo;
    }
    if (!empty($status)) {
      $conditions[] = "b.status = $" . $paramIndex++;
      $fparams[] = $status;
    }
    if (!empty($estado_solicitud)) {
      $conditions[] = "b.estado_solicitud = $" . $paramIndex++;
      $fparams[] = $estado_solicitud;
    }
    if (!empty($tipo_beneficio)) {
      $conditions[] = "b.tipo_beneficio = $" . $paramIndex++;
      $fparams[] = $tipo_beneficio;
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

    $querySQL = "SELECT b.*,es.nombre AS estadon,tb.nombre AS tipon FROM itmc.beneficiario AS b LEFT JOIN itmc.estado_solicitud AS es ON b.estado_solicitud = es.id LEFT JOIN itmc.tipo_beneficio AS tb ON b.tipo_beneficio = tb.id $where $limit";
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
