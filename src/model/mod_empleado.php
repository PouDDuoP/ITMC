<?php

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] >0) {
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
    $querySQL = "INSERT INTO itmc.empleado(id, nombre, apellido, email, cargo, fecha_ingreso, ext_telefono,nro_telefono, departamento, sueldo) VALUES('$cedula_id','$nombre','$apellido','$email',$cargo,'$fecha_ingreso','$ext_telf','$nro_telf',$departamento,$sueldo)";
		$operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
		return $operacion;
  }

  function consultar_empleados ($rango,$pgconn)
  {
    $limit = "";
    if (!empty($rango) && $rango > 0) {
      $limit = "LIMIT $rango";
    }elseif ($rango == 'ALL') {
      $limit = "";
    }else {
      $limit = "LIMIT 0";
    }
    $querySQL = "SELECT e.*,d.nombre AS departamenton, c.nombre AS cargon FROM itmc.empleado AS e LEFT JOIN itmc.departamento AS d ON e.departamento = d.id LEFT JOIN itmc.cargo AS c ON e.cargo = c.id $limit";
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

  function consultar_empleado ($cedula_id,$pgconn)
  {
    $querySQL = "SELECT e.*,d.nombre AS departamenton,c.nombre AS cargon FROM itmc.empleado AS e LEFT JOIN itmc.departamento AS d ON e.departamento = d.id LEFT JOIN itmc.cargo AS c ON e.cargo = c.id WHERE e.id = '$cedula_id'";
    // echo $querySQL;
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
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
    $querySQL = "SELECT id,status FROM itmc.empleado WHERE id = '$cedula_id'";
    // echo $querySQL;
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
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
    $querySQL = "UPDATE itmc.empleado SET nombre='$nombre', apellido='$apellido', email='$email', cargo=$cargo, ext_telefono='$ext_telf', nro_telefono='$nro_telf', departamento=$departamento, sueldo=$sueldo WHERE id = '$cedula_id'";
    // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function HabiOrInha_empleado ($cedula_id,$status,$pgconn)
  {
    $querySQL = "UPDATE itmc.empleado SET status='$status' WHERE id = '$cedula_id'";
    // echo "$querySQL";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function despedir_empleado ($cedula_id,$pgconn)
  {
    $querySQL = "UPDATE itmc.empleado SET status = false WHERE id = '$cedula_id'";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function recontratar_empleado ($fecha_ingreso,$cedula_id)
  {
    $querySQL = "UPDATE itmc.empleado SET status = true, fecha_ingreso = '$fecha_ingreso' WHERE id = '$cedula_id'";
    $operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
  }

  function filtrar_empleados ($cedula_id,$fecha_ingreso,$fecha_hasta,$departamento,$sueldo,$sueldo_hasta,$status,$rango,$pgconn)
  {
    $where = "";
    if   (!empty($cedula_id) || !empty($fecha_ingreso) || !empty($fecha_hasta) || !empty($departamento) || !empty($sueldo) || !empty($sueldo_hasta) || !empty($status)) {
      $where = "WHERE ";
    }else {
      $where = "";
    }

    $cedula = !empty($cedula_id) ? "AND e.id = '$cedula_id' " : "";
    $fecha = !empty($fecha_ingreso) && !empty($fecha_hasta) ? "AND e.fecha_ingreso BETWEEN '$fecha_ingreso 00:00:00' AND '$fecha_hasta 24:00:00' " : "";
    $departa = !empty($departamento) ? "AND e.departamento = $departamento " : "";
    $suel = !empty($sueldo) && !empty($sueldo_hasta) ? "AND e.sueldo BETWEEN $sueldo AND $sueldo_hasta " : "";
    $stat = !empty($status) ? "e.status = '$status'" : "";

    $limit = "";
    if (!empty($rango) && $rango > 0) {
      $limit = "LIMIT $rango";
    }elseif ($rango == 'ALL') {
      $limit = "";
    }else {
      $limit = "LIMIT 0";
    }

    $querySQL = "SELECT e.*,d.nombre AS departamenton, c.nombre AS cargon FROM itmc.empleado AS e LEFT JOIN itmc.departamento AS d ON e.departamento = d.id LEFT JOIN itmc.cargo AS c ON e.cargo = c.id $where $stat $cedula $fecha $departa $suel $limit";
    // echo $querySQL;
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


  }else {
    header('location: ../view/view_menu.php');
    session_destroy();
  }
}else {
header('location: ../index.php');
session_destroy();
}


?>
