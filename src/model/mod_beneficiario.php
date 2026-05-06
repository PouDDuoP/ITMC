<?php


if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] >0) {
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
    $querySQL = "INSERT INTO itmc.beneficiario (cedula_empleado, cod_hijo, tipo_beneficio, fecha_solicitud, estado_solicitud) VALUES ('$cedula_id',$id_hijo,$tipo_beneficio,'$fecha_solicitado',$estado_solicitud)";
        // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

		return $operacion;
  }

  function consultar_solicitud_beneficio ($rango,$pgconn)
  {
    $limit = "";
    if (!empty($rango)) {
      $limit = "LIMIT $rango";
    }else {
      $limit = "";
    }
    $querySQL = "SELECT * FROM itmc.beneficiario $limit";
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

  function consultar_solicitud_beneficio_anual ($cedula_id,$id_hijo,$fecha_solicitado,$tipo_beneficio,$pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.beneficiario WHERE cedula_empleado = '$cedula_id' AND TO_CHAR(fecha_solicitud, 'YYYY') = '$fecha_solicitado' AND tipo_beneficio = $tipo_beneficio AND cod_hijo = $id_hijo AND status = TRUE GROUP BY id";
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

  function consultar_solicitud_beneficio_mensual ($cedula_id,$id_hijo,$fecha_solicitado,$tipo_beneficio,$pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.beneficiario WHERE cedula_empleado = '$cedula_id' AND TO_CHAR(fecha_solicitud, 'YYYY-MM') = '$fecha_solicitado' AND tipo_beneficio = $tipo_beneficio AND cod_hijo = $id_hijo AND status = TRUE GROUP BY id";
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


  function actualizar_solicitud_beneficio ($id,$status,$estado_solicitud,$pgconn)
  {
    $set_status = "";
    if (!empty($status)) {
      $set_status = "status=$status,";
    }else {
      $set_status = "";
    }
    $querySQL = "UPDATE itmc.beneficiario SET $set_status estado_solicitud='$estado_solicitud' WHERE id = '$id'";
    // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function filtrar_solicitudes_beneficio ($fecha_solicitado,$fecha_solicitado_hasta,$id,$cedula_id,$cod_hijo,$status,$estado_solicitud,$tipo_beneficio,$rango,$pgconn)
  {
    $fecha = !empty($fecha_solicitado) && !empty($fecha_solicitado_hasta) ? "WHERE b.fecha_solicitud BETWEEN '$fecha_solicitado 00:00:00' AND '$fecha_solicitado_hasta 24:00:00'" : "";
    $id_solicitud = !empty($id) ? "AND b.id = $id" : "";
    $cedula = !empty($cedula_id) ? "AND b.cedula_empleado = '$cedula_id'" : "";
    $hijo = !empty($cod_hijo) ? "AND b.cod_hijo = $cod_hijo" : "";
    $status_solicitud = !empty($status) ? "AND b.status = '$status'" : "";
    $estado = !empty($estado_solicitud) ? "AND b.estado_solicitud = $estado_solicitud" : "";
    $tipo = !empty($tipo_beneficio) ? "AND b.tipo_beneficio = $tipo_beneficio" : "";
    $limit = "";
    if (!empty($rango) && $rango > 0) {
      $limit = "LIMIT $rango";
    }elseif ($rango == 'ALL') {
      $limit = "";
    }else {
      $limit = "LIMIT 0";
    }

    $querySQL = "SELECT b.*,es.nombre AS estadon,tb.nombre AS tipon FROM itmc.beneficiario AS b LEFT JOIN itmc.estado_solicitud AS es ON b.estado_solicitud = es.id LEFT JOIN itmc.tipo_beneficio AS tb ON b.tipo_beneficio = tb.id $fecha $id_solicitud $cedula $hijo $status_solicitud $estado $tipo $limit";
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
