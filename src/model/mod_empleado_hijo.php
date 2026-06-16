<?php

class Hijo
{
  private $id;
  private $cedula_id;
  private $cedula_id_padre;
  private $nombre;
  private $apellido;
  private $fecha_nacimiento;
  private $fecha_nacimiento_hasta;
  private $nivel_academico;
  private $pgconn;

  function inicializar($id,$cedula_id,$cedula_id_padre,$nombre,$apellido,$fecha_nacimiento,$fecha_nacimiento_hasta,$nivel_academico,$pgconn)
  {
    $this->cedula_id_padre = $cedula_id_padre;
    $this->cedula_id = $cedula_id;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->fecha_nacimiento = $fecha_nacimiento;
    $his->fecha_nacimiento_hasta = $fecha_nacimiento_hasta;
    $this->nivel_academico = $nivel_academico;
    $this->pgconn = $pgconn;
  }

  function registrar_hijo ($cedula_id,$nombre,$apellido,$fecha_nacimiento,$nivel_academico,$pgconn)
  {
    $querySQL = "INSERT INTO itmc.hijo(cedula_hijo, nombre, apellido, fecha_nacimiento, nivel_academico) VALUES($1, $2, $3, $4, $5)";
		$operacion = pg_query_params($pgconn,$querySQL,array($cedula_id, $nombre, $apellido, $fecha_nacimiento, $nivel_academico)) or die ("Consulta errónea: ".pg_last_error());
		return $operacion;
  }

  function registrar_empleado_hijo ($cedula_id_padre,$cedula_id,$nombre,$apellido,$fecha_nacimiento,$nivel_academico,$pgconn)
  {
    $querySQL = "INSERT INTO itmc.hijo_empleado(cedula_empleado, hijo) VALUES($1,(SELECT id FROM itmc.hijo WHERE cedula_hijo = $2 AND nombre = $3 AND apellido = $4 AND fecha_nacimiento = $5 AND nivel_academico = $6 ORDER BY id DESC LIMIT 1))";
    // echo $querySQL;
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id_padre, $cedula_id, $nombre, $apellido, $fecha_nacimiento, $nivel_academico)) or die ("Consulta errónea: ".pg_last_error());
		return $operacion;
  }

  // function consultar_empleado_hijos ($pgconn)
  // {
  //   $querySQL = "SELECT * FROM itmc.hijo";
  //   $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
  //   if($operacion)
	// 	{
	// 		// $columna = pg_fetch_array($operacion);
	// 		// return $columna;
  //     return $operacion;
	// 	}
	// 	 else
	// 	{
	// 		return false;
	// 	}
  // }

  function consultar_empleado_hijo ($cedula_id_padre,$pgconn)
  {
    $querySQL = "SELECT he.*,h.* FROM itmc.hijo_empleado AS he INNER JOIN itmc.hijo AS h ON he.hijo = h.id WHERE cedula_empleado = $1";
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id_padre)) or die ("Consulta errónea: ".pg_last_error());
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

  // function consultar_empleado_hijo_id ($id,$pgconn)
  // {
  //   $querySQL = "SELECT id FROM itmc.hijo WHERE id = '$id'";
  //   $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
  //   if(!empty($operacion))
  //   {
  //     $columna = pg_fetch_array($operacion);
  //     return $columna;
  //     // return $operacion;
  //   }
  //    else
  //   {
  //     return false;
  //   }
  // }

  function actualizar_empleado_hijo ($id,$cedula_id,$nombre,$apellido,$fecha_nacimiento,$nivel_academico,$pgconn)
  {
    $querySQL = "UPDATE itmc.hijo SET cedula_hijo=$1, nombre=$2, apellido=$3, nivel_academico=$4 WHERE id = $5";
    // echo "$querySQL";
    $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id, $nombre, $apellido, $nivel_academico, $id)) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }


    function consultar_empleado_hijo_cantidad ($cedula_id,$pgconn)
    {
      $querySQL = "SELECT count(*) FROM itmc.hijo_empleado WHERE cedula_empleado = $1 GROUP BY id";
      $operacion = pg_query_params($pgconn,$querySQL,array($cedula_id)) or die ("Consulta errónea: ".pg_last_error());
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
    function estadistica_hijo_fecha ($fecha_nacimiento,$fecha_nacimiento_hasta,$pgconn)
    {
      $querySQL = "SELECT count(*) FROM itmc.hijo_empleado AS he INNER JOIN itmc.hijo AS h ON h.id = he.hijo WHERE h.fecha_nacimiento BETWEEN $1 AND $2 GROUP BY h.id";
      $operacion = pg_query_params($pgconn,$querySQL,array($fecha_nacimiento . " 00:00:00", $fecha_nacimiento_hasta . " 24:00:00")) or die ("Consulta errónea: ".pg_last_error());
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

    function estadistica_hijo_total ($pgconn)
    {
      $querySQL = "SELECT count(*) FROM itmc.hijo_empleado AS he INNER JOIN itmc.hijo AS h ON h.id = he.hijo GROUP BY h.id";
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
