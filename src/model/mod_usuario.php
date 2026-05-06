<?php
// clase Usuario

class Usuario {
	private $id;
	private $cedula_id;
	private $clave;
	private $perfil;
	private $status;
	private $rango = 1;
	private $pgconn;

	public function inicializar($id,$cedula_id,$clave,$perfil,$status,$rango,$pgconn){
			$this->id 			 = $id;
			$this->cedula_id = $cedula_id;
			$this->clave 		 = $clave;
			$this->perfil    = $perfil;
			$this->status    = $status;
			$this->rango		 = $rango;
			$this->pgconn    = $pgconn;
	}
	// validacion de campos de clase
	function contar_perfiles ($cedula_id,$pgconn){
		$querySQL = "SELECT u.cedula_empleado,u.perfil,p.nombre FROM itmc.usuario AS u INNER JOIN itmc.perfil_usuario AS p ON u.perfil = p.id WHERE u.cedula_empleado = '$cedula_id'";
	 	$operacion = pg_query($pgconn,$querySQL) or die("Consulta errónea: ".pg_last_error());
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
	function autenticar_usuario ($cedula_id,$clave,$status,$pgconn)
	{
		$clave = md5($clave);
		$querySQL = "SELECT * FROM itmc.usuario WHERE cedula_empleado = '$cedula_id' AND clave ='$clave' AND status = '$status' ";
	 	$operacion = pg_query($pgconn,$querySQL) or die("Consulta errónea: ".pg_last_error());
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
		// archivo de bitacora, para intentos de ingreso a el sistema
	}


	function autenticar_usuario_perfil ($cedula_id,$clave,$perfil,$status,$pgconn)
	{
		$clave = md5($clave);
		$querySQL = "SELECT * FROM itmc.usuario WHERE cedula_empleado = '$cedula_id' AND clave = '$clave' AND perfil = $perfil AND status = '$status'";
		$operacion = pg_query($pgconn,$querySQL) or die("Consulta errónea: ".pg_last_error());
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
		// archivo de bitacora, para intentos de ingreso a el sistema
	}

	function validar_prefil ($cedula_id,$perfil,$pgconn)
	{
		$querySQL = "SELECT * FROM itmc.usuario WHERE cedula_empleado = '$cedula_id' AND perfil = $perfil";
		// echo "$querySQL";
		$operacion = pg_query($pgconn,$querySQL) or die("Consulta errónea: ".pg_last_error());
		if($operacion)
		{
			$columna = pg_fetch_array($operacion);
			return $columna;
			// return $operacion;
		}
		 else
		{
			return false;
		}
		// archivo de bitacora, para intentos de ingreso a el sistema
	}

	function registrar_usuario($cedula_id,$clave,$perfil,$pgconn)
	{
		$clave = md5($clave);
		$querySQL = "INSERT INTO itmc.usuario(cedula_empleado, clave, perfil) VALUES ('$cedula_id', '$clave', $perfil)";
		$operacion = pg_query($pgconn,$querySQL) or die("Consulta errónea: ".pg_last_error());
		return $operacion;
	}
	function modificar_usuario($id,$cedula_id,$perfil,$status,$pgconn)
	{
		$querySQL = "UPDATE itmc.usuario SET status = '$status' WHERE cedula_empleado = '$cedula_id' AND id = $id AND perfil = $perfil";
		$operacion = pg_query($pgconn,$querySQL) or die("Consulta errónea: ".pg_last_error());
		if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
	}

	function HabiOrInha_usuario ($cedula_id,$status,$pgconn)
	{
		$querySQL = "UPDATE itmc.usuario SET status = '$status' WHERE cedula_empleado = '$cedula_id'";
		// echo "$querySQL";
		$operacion = pg_query($pgconn,$querySQL) or die("Consulta errónea: ".pg_last_error());
		if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
	}

	function HabiOrInha_usuario_perfil ($cedula_id,$status,$perfil,$pgconn)
	{
		$querySQL = "UPDATE itmc.usuario SET status = '$status' WHERE cedula_empleado = '$cedula_id' AND perfil = $perfil";
		// echo "$querySQL";
		$operacion = pg_query($pgconn,$querySQL) or die("Consulta errónea: ".pg_last_error());
		if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
	}

	function modificar_clave($cedula_id,$clave,$perfil,$pgconn)
	{
		$clave = md5($clave);
		$querySQL = "UPDATE itmc.usuario SET clave='$clave' WHERE cedula_empleado = '$cedula_id' AND perfil = $perfil";
		$operacion = pg_query($pgconn,$querySQL) or die("Consulta errónea: ".pg_last_error());
		// $query= @pg_query($query); //@ suprime mensajes de error en navegador
		if ($operacion) {
			return "ok";
		}else {
			return "nok";
		}
	}

	function consultar_usuarios ($cedula_id,$pgconn)
	{
		$querySQL = "SELECT u.*,p.nombre FROM itmc.usuario AS u INNER JOIN itmc.perfil_usuario AS p ON u.perfil = p.id WHERE u.cedula_empleado = '$cedula_id'";
		$operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

		if (!empty($operacion)) {
			return $operacion;
		} else {
			return false;
		}
	}

	function consultar_usuario_id ($id,$pgconn)
	{
		$querySQL = "SELECT u.id,u.cedula_empleado,u.perfil,u.status,p.nombre FROM itmc.usuario AS u INNER JOIN itmc.perfil_usuario AS p ON u.perfil = p.id WHERE u.id = $id";
		$operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

		if (!empty($operacion)) {
			return $operacion;
		} else {
			return false;
		}
	}

	function listar_usuarios ($rango,$pgconn)
	{
		$limit = "";
    if (!empty($rango) && $rango > 0) {
      $limit = "LIMIT $rango";
    }elseif ($rango == 'ALL') {
      $limit = "";
    }else {
      $limit = "LIMIT 0";
    }

		$querySQL = "SELECT u.*,p.nombre FROM itmc.usuario AS u LEFT JOIN itmc.perfil_usuario AS p ON u.perfil = p.id $limit";
		$operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

		if (!empty($operacion)) {
			return $operacion;
		} else {
			return false;
		}
	}

	function filtrar_usuarios ($id,$cedula_id,$perfil,$status,$rango,$pgconn)
	{
		$where = "";
		if   (!empty($id) || !empty($cedula_id)  || !empty($perfil) || !empty($status)) {
			$where = "WHERE ";
		}else {
			$where = "";
		}

		$cod = !empty($id) ? "AND u.id = '$id' " : "";
		$cedula = !empty($cedula_id) ? "AND u.cedula_empleado = '$cedula_id' " : "";
		$perfil_u = !empty($perfil) ? "AND u.perfil = $perfil " : "";
		$status_u = !empty($status) ? "u.status = '$status' " : "";

		$limit = "";
    if (!empty($rango) && $rango > 0) {
      $limit = "LIMIT $rango";
    }elseif ($rango == 'ALL') {
      $limit = "";
    }else {
      $limit = "LIMIT 0";
    }

		$querySQL = "SELECT u.*,p.nombre FROM itmc.usuario AS u LEFT JOIN itmc.perfil_usuario AS p ON u.perfil = p.id $where $status_u $cod $cedula $perfil_u $limit";
		$operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());

		if (!empty($operacion)) {
			return $operacion;
		} else {
			return false;
		}
	}

  function estadistica_usuarios_perfil ($perfil,$pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.usuario WHERE status = 't' AND perfil = $perfil GROUP BY id";
		// echo "$querySQL <hr>";
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

	function estadistica_usuarios_total ($pgconn)
  {
    $querySQL = "SELECT count(*) FROM itmc.usuario WHERE status = 't' GROUP BY id";
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
// 	function crearUsuario()
// 	{
// 		 $query = "INSERT INTO usuario (cedula_identidad, nombres, apellidos, clave, email, perfil, fecha_ingreso, cargo, departamento, telefono, ext ) VALUES ('".$unEmpleado->cedulaIdentidad."','".$unEmpleado->nombres."','".$unEmpleado->apellidos."','".$unEmpleado->clave."','".$unEmpleado->email."',".$unEmpleado->perfil.",'".$unEmpleado->fechaIngreso."','".$unEmpleado->cargo."','".$unEmpleado->departamento."','".$unEmpleado->telefono."','".$unEmpleado->ext."')";
// 		 try{
// 			 $query= @pg_query($query); //@ suprime mensajes de error en navegador
// 			 if($query==false)
// 			 {
// 				 throw new Exception();
// 			 }
// 		 }
// 		 catch (Exception $e)
// 		 {
//
// 		 }
// 		 return $query;
// 	} // fin
//
// 	function ingresar()
// 	{
// 		$valido=false;
// 		$query="SELECT * FROM usuario WHERE cedula_identidad ='".$this->cedulaIdentidad."'";
// 		$rs=@pg_query($query);
// 		if($rs){
// 			$datos=pg_fetch_array($rs,null);
// 			if($this->clave==$datos['clave'])
// 			{
// 				$this->nombres=$datos['nombres'];
// 				$this->apellidos=$datos['apellidos'];
// 				$this->perfil=$datos['perfil'];
// 				$this->email=$datos['email'];
// 				$this->fechaIngreso=$datos['fecha_ingreso'];
// 				$valido = true; // se retorna los datos del empleado
// 			}
// 		}
// 		// archivo de bitacora, se debe incluir en cada operacion
// 		file_put_contents("bitacora.log", "Empleado :".$this->nombres." hora: ".date('l jS \of F Y h:i:s A')."Evento: Ingresar Estado : ".$valido."\r\n", FILE_APPEND | LOCK_EX );
// 		return $valido;		// error en usuario
// 	}
//
// 	function reestablecerClave(){
// 		/*
// 		Configuracion de php.ini
// 		SMTP=smtp.gmail.com
// 		smtp_port=25
// 		sendmail_from = my-gmail-id@gmail.com la direccion que envia
// 		sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t" direccion donde esta el servidor SMTP
//
// 		Configuracion de sendmail.ini
// 		smtp_server=smtp.gmail.com
// 		smtp_port=25
// 		auth_username=my-gmail-id@gmail.com igual a la direccion que envia en php.ini
// 		auth_password=my-gmail-password clave
// 		force_sender=my-gmail-id@gmail.com   misma direccion
// 		 */
// 		srand(time()); // semilla de generacion de numeros aleatorias para que sean diferentes
// 		$clave="";
// 		for($i=1;$i<=8;$i++){
// 			$clave=$clave.chr(rand(48,125)); //ocho caracteres de numeros, letras y simbolos
// 		}
// 		$mensaje="Usted ha solicitado reestablecer su contrase�a: \r\n Su nueva contrase�a : ".$clave;
// 		// es necesario tener un servidor SMTP activo para enviar emails
// 		//mail('jmata.panzer@gmail.com', 'Solicitud de reestablecimiento de Contrase�a', $mensaje);
// 		$query ="SELECT email FROM empleados WHERE cedula_identidad='".$this->cedulaIdentidad."'";
// 		$rs=pg_query($query);
// 		if($rs){
// 			$datos=pg_fetch_array($rs,null);
// 			$email=$datos['email'];
// 			$query = "UPDATE empleados SET clave ='".md5($clave)."' WHERE cedula_identidad= '".$this->cedulaIdentidad."'";
// 			$rs= pg_query($query); //@ suprime mensajes de error en navegador
// 			mail($email, 'Solicitud de reestablecimiento de Contrase�a', $mensaje);
// 		}
// 		//file_put_contents("bitacora.log", "Empleado :".$this->nombres." hora: ".date('l jS \of F Y h:i:s A')."Evento: Reiniciar Clave Estado : ".$valido."\r\n", FILE_APPEND | LOCK_EX );
// 		return $rs;
// 	}
//
// 	function cambiarClave($claveActual, $claveNueva){
// 		$valido = false;
// 		$query = "SELECT clave FROM empleados WHERE cedula_identidad='".$this->cedulaIdentidad."'";
// 		$rs=pg_query($query);
// 		$datos=pg_fetch_array($rs,null);
// 		if($datos['clave']==md5($claveActual))
// 		{
// 			$query = "UPDATE empleados SET clave ='".md5($claveNueva)."' WHERE cedula_identidad= '".$this->cedulaIdentidad."'";
// 			$rs= pg_query($query); //@ suprime mensajes de error en navegador
// 			$valido = true;
// 		}
// 		file_put_contents("bitacora.log", "Empleado :".$this->nombres." hora: ".date('l jS \of F Y h:i:s A')." Evento: Cambio Clave Estado : ".$valido."\r\n", FILE_APPEND | LOCK_EX );
// 		return $valido;
// 	}
//
// 	function generarSolictud(Solicitud $unaSolicitud)
// 	{
// 		$query = "INSERT INTO solicitudes ( numero_solicitud, cedula_identidad, fecha_solicitud, tipo_solicitud, descripcion, departamento, estado ) VALUES (".$unaSolicitud->numeroSolicitud.", '".$unaSolicitud->cedulaIdentidad."','".$unaSolicitud->fecha_solicitud."',".$unaSolicitud->tipo.",'".$unaSolicitud->descripcion."',".$unaSolicitud->departamento.",".$unaSolicitud->estado.")";
// 		try{
// 			$query= @pg_query($query); //@ suprime mensajes de error en navegador
// 			if($query==false)
// 			{
// 				throw new Exception();
// 			}
// 		}
// 		catch (Exception $e)
// 		{
//
// 		}
// 		file_put_contents("bitacora.log", "Empleado :".$this->nombres." hora: ".date('l jS \of F Y h:i:s A')."Evento: Generar Solicitud : ".$valido."\r\n", FILE_APPEND | LOCK_EX );
// 		return $query;
// 	} // fin de generarSolictud
//
} // fin clase usuario




?>
