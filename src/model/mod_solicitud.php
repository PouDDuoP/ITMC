<?php

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] >0) {
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
    $querySQL = "INSERT INTO itmc.solicitud(fecha_solicitud, cedula_solicitante, descripcion, tipo_solicitud,estado_solicitud, departamento)VALUES ('$fecha_solicitado', '$cedula_id', '$descripcion', $tipo_solicitud, $estado_solicitud, $departamento)";
        // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_solicitud ($rango,$pgconn)
  {
    $limit = "";
    if (!empty($rango)) {
      $limit = "LIMIT $rango";
    }else {
      $limit = "";
    }
    $querySQL = "SELECT * FROM itmc.solicitud $limit";
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

  function consultar_solicitud_fecha ($cedula_id,$fecha_solicitado,$tipo_solicitud,$pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.solicitud WHERE cedula_solicitante = '$cedula_id' AND TO_CHAR(fecha_solicitud, 'YYYY-MM') = '$fecha_solicitado' AND tipo_solicitud = $tipo_solicitud GROUP BY id";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    echo "$querySQL";
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
    $set_departamento = "";
    if (!empty($departamento)) {
      $set_departamento = "departamento='$departamento',";
    }else {
      $set_departamento = "";
    }
    $querySQL = "UPDATE itmc.solicitud SET $set_departamento estado_solicitud='$estado_solicitud' WHERE id = '$id'";
    // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		} else {
			return "nok";
		}
  }

  function filtrar_solicitudes ($fecha_solicitado,$fecha_solicitado_hasta,$id,$cedula_id,$estado_solicitud,$tipo_solicitud,$rango,$pgconn)
  {
    $fecha = !empty($fecha_solicitado) && !empty($fecha_solicitado_hasta) ? "WHERE fecha_solicitud BETWEEN '$fecha_solicitado 00:00:00' AND '$fecha_solicitado_hasta 24:00:00'" : "";
    $id_solicitud = !empty($id) ? "AND s.id = $id" : "";
    $cedula = !empty($cedula_id) ? "AND s.cedula_solicitante = '$cedula_id'" : "";
    $estado = !empty($estado_solicitud) ? "AND s.estado_solicitud = $estado_solicitud" : "";
    $tipo = !empty($tipo_solicitud) ? "AND s.tipo_solicitud = $tipo_solicitud" : "";
    $limit = "";
    if (!empty($rango) && $rango > 0) {
      $limit = "LIMIT $rango";
    }elseif ($rango == 'ALL') {
      $limit = "";
    }else {
      $limit = "LIMIT 0";
    }

    $querySQL = "SELECT s.*,es.nombre AS estadon,ts.nombre AS tipon FROM itmc.solicitud AS s LEFT JOIN itmc.estado_solicitud AS es ON s.estado_solicitud = es.id LEFT JOIN itmc.tipo_solicitud AS ts ON s.tipo_solicitud = ts.id $fecha $id_solicitud $cedula $estado $tipo $limit";
    // echo $querySQL;
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

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

  }else {
    header('location: ../view/view_menu.php');
    session_destroy();
  }
}else {
header('location: ../index.php');
session_destroy();
}


?>
