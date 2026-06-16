<?php

class Empleado
{
  private $cedula_id;
  private $nombre;
  private $apellido;
  private $email;
  private $cargo;
  private $fecha_ingreso;
  private $fecha_hasta;
  private $ext_telf;
  private $nro_telf;
  private $departamento;
  private $sueldo;
  private $sueldo_hasta;
  private $status;
  private $rango = 1;
  private $pgconn;

  function inicializar($cedula_id,$nombre,$apellido,$email,$cargo,$fecha_ingreso,$fecha_hasta,$ext_telf,$nro_telf,$departamento,$sueldo,$sueldo_hasta,$status,$rango,$pgconn)
  {
    $this->cedula_id = $cedula_id;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->email = $email;
    $this->cargo  = $cargo;
    $this->fecha_ingreso = $fecha_ingreso;
    $this->fecha_hasta = $fecha_hasta;
    $this->ext_telf = $ext_telf;
    $this->nro_telf = $nro_telf;
    $this->departamento = $departamento;
    $this->sueldo = $sueldo;
    $this->sueldo_hasta = $sueldo_hasta;
    $this->status = $status;
    $this->rango = $rango;
    $this->pgconn = $pgconn;

  }

  function registrar_empleado ($cedula_id,$nombre,$apellido,$email,$cargo,$fecha_ingreso,$ext_telf,$nro_telf,$departamento,$sueldo,$pgconn)
  {
    $querySQL = "INSERT INTO itmc.empleado(id, nombre, apellido, email, cargo, fecha_ingreso, ext_telefono,nro_telefono, departamento, sueldo) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
		$operacion = pg_query_params($pgconn,$querySQL,array($cedula_id, $nombre, $apellido, $email, $cargo, $fecha_ingreso, $ext_telf, $nro_telf, $departamento, $sueldo)) or die ("Consulta errónea: ".pg_last_error());
		return $operacion;
  }

  function consultar_empleados ($rango,$pgconn)
  {
    $limit = "";
    $lparams = array();
    if (!empty($rango) && $rango > 0) {
      $limit = "LIMIT $1";
      $lparams = array((int)$rango);
    }elseif ($rango == 'ALL') {
      $limit = "";
    }else {
      $limit = "LIMIT 0";
    }
    $querySQL = "SELECT e.*,d.nombre AS departamenton, c.nombre AS cargon FROM itmc.empleado AS e LEFT JOIN itmc.departamento AS d ON e.departamento = d.id LEFT JOIN itmc.cargo AS c ON e.cargo = c.id $limit";
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

  function consultar_empleado ($cedula_id,$pgconn)
  {
    $querySQL = "SELECT e.*,d.nombre AS departamenton,c.nombre AS cargon FROM itmc.empleado AS e LEFT JOIN itmc.departamento AS d ON e.departamento = d.id LEFT JOIN itmc.cargo AS c ON e.cargo = c.id WHERE e.id = $1";
    // echo $querySQL;
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id)) or die ("Consulta errónea: ".pg_last_error());
    if(!empty($operacion))
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

  function consultar_empleado_cedula ($cedula_id,$pgconn)
  {
    $querySQL = "SELECT id,status FROM itmc.empleado WHERE id = $1";
    // echo $querySQL;
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id)) or die ("Consulta errónea: ".pg_last_error());
    if(!empty($operacion))
    {
      $columna = pg_fetch_array($operacion);
      return $columna;
      // return $operacion;
    }
     else
    {
      return false;
    }
  }

  function actualizar_empleado ($cedula_id,$nombre,$apellido,$email,$cargo,$ext_telf,$nro_telf,$departamento,$sueldo,$pgconn)
  {
    $querySQL = "UPDATE itmc.empleado SET nombre=$1, apellido=$2, email=$3, cargo=$4, ext_telefono=$5, nro_telefono=$6, departamento=$7, sueldo=$8 WHERE id = $9";
    // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($nombre, $apellido, $email, $cargo, $ext_telf, $nro_telf, $departamento, $sueldo, $cedula_id)) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function HabiOrInha_empleado ($cedula_id,$status,$pgconn)
  {
    $querySQL = "UPDATE itmc.empleado SET status=$1 WHERE id = $2";
    // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($status, $cedula_id)) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function despedir_empleado ($cedula_id,$pgconn)
  {
    $querySQL = "UPDATE itmc.empleado SET status = false WHERE id = $1";
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id)) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function recontratar_empleado ($fecha_ingreso,$cedula_id)
  {
    $querySQL = "UPDATE itmc.empleado SET status = true, fecha_ingreso = $1 WHERE id = $2";
    $operacion = pg_query_params($pgconn,$querySQL,array($fecha_ingreso, $cedula_id)) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function filtrar_empleados ($cedula_id,$fecha_ingreso,$fecha_hasta,$departamento,$sueldo,$sueldo_hasta,$status,$rango,$pgconn)
  {
    $conditions = array();
    $fparams = array();
    $paramIndex = 1;

    if (!empty($cedula_id)) {
      $conditions[] = "e.id = $" . $paramIndex++;
      $fparams[] = $cedula_id;
    }
    if (!empty($fecha_ingreso) && !empty($fecha_hasta)) {
      $conditions[] = "e.fecha_ingreso BETWEEN $" . $paramIndex++ . " AND $" . $paramIndex++;
      $fparams[] = $fecha_ingreso . " 00:00:00";
      $fparams[] = $fecha_hasta . " 24:00:00";
    }
    if (!empty($departamento)) {
      $conditions[] = "e.departamento = $" . $paramIndex++;
      $fparams[] = $departamento;
    }
    if (!empty($sueldo) && !empty($sueldo_hasta)) {
      $conditions[] = "e.sueldo BETWEEN $" . $paramIndex++ . " AND $" . $paramIndex++;
      $fparams[] = $sueldo;
      $fparams[] = $sueldo_hasta;
    }
    if (!empty($status)) {
      $conditions[] = "e.status = $" . $paramIndex++;
      $fparams[] = $status;
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

    $querySQL = "SELECT e.*,d.nombre AS departamenton, c.nombre AS cargon FROM itmc.empleado AS e LEFT JOIN itmc.departamento AS d ON e.departamento = d.id LEFT JOIN itmc.cargo AS c ON e.cargo = c.id $where $limit";
    // echo $querySQL;
    $operacion = pg_query_params($pgconn,$querySQL,$fparams) or die ("Consulta errónea: ".pg_last_error());
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

  function estadistica_empleado_con_hijo ($pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.hijo_empleado AS he INNER JOIN itmc.empleado AS e ON e.id = he.cedula_empleado WHERE e.status = 't' GROUP BY e.id";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
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

  function estadistica_empleado_total ($pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.empleado WHERE status = 't' GROUP BY id";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
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

}


?>
