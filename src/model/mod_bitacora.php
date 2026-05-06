
<?php
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] >0) {

    $url_pase = parse_url( $_SERVER['HTTP_REFERER'] );
    if (!isset($url_pase[ "port" ])) {
      $host = $url_pase[ "scheme" ] . "://" . $url_pase[ "host" ]; // parseamos para obtener el scheme "http:" y el Host "Locahost:8080 or 80 ..."
    } else {
      $host = $url_pase[ "scheme" ] . "://" . $url_pase[ "host" ] . ":" . $url_pase[ "port" ]; // parseamos para obtener el scheme "http:" y el Host "Locahost:8080 or 80 ..."
    }
    $path = $url_pase[ "path" ];
    $url = $host.$path;

    date_default_timezone_set('America/La_Paz');
    $fecha = date('Y-m-d');

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
    $querySQL = "SELECT itmc.sp_bitacora ('$cedula_id',$usuario_id,'$operacion','$tabla','$columna','$valor_original','$valor_nuevo','$url','$fecha')";
		$operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
		return $operacion;
  }

  function consultar_bitacora ($rango,$pgconn)
  {
    $limit = "";
    if (!empty($rango)) {
      $limit = "LIMIT $rango";
    }elseif (is_string($limit)) {
      $limit = "";
    }else {
      $limit = "";
    }
    $querySQL = "SELECT * FROM itmc.bitacora ORDER BY id DESC $limit";
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
