<?php

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] >0) {
    class Auditoria
    {
      private ;
      private $pgconn;

      function inicializar($pgconn)
      {
        $this-> = ;
        $this->pgconn = $pgconn;

      }

      function registrar_auditoria ($pgconn)
      {
        $querySQL = "";
    		$operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
    		return $operacion;
      }

      function consultar_auditorias ($rango,$pgconn)
      {
        $limit = "";
        if (!empty($rango)) {
          $limit = "LIMIT $rango";
        }elseif (is_string($limit)) {
          $limit = "";
        }else {
          $limit = "";
        }
        $querySQL = "";
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
