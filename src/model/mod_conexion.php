<?php

class ConexionPGSQL {

	private $host;
	private $port;
	private $db;
	private $user;
	private $pass;
	private $conexion;
	private $url;

		function __construct() {

			// Usar variable de entorno si está disponible, sino valor por defecto
			$this->host= getenv('DB_HOST') ? getenv('DB_HOST') : 'db';
			$this->port = getenv('DB_PORT') ? getenv('DB_PORT') : '5432';
			$this->db= getenv('DB_NAME') ? getenv('DB_NAME') : 'dbitmc';
			$this->user= getenv('DB_USER') ? getenv('DB_USER') : 'postgres';
			$this->pass= getenv('DB_PASS') ? getenv('DB_PASS') : 'DB_PASS'; // poné tu contraseña en .env o DB_PASS
			$this->conexion="host=".$this->host." port=".$this->port." password=".$this->pass." user=".$this->user." dbname=".$this->db."";

		}

	public function conectar() {

		$this->url = pg_connect($this->conexion) or die("ERROR DE CONEXION");
		return $this->url;
		// $this->conexion=pg_connect("host=".$this->host." port=".$this->port." password=".$this->$pass." user=".$this->user." dbname=".$this->db."");
		// return $this->conexion;

		// $this->url = pg_connect("host=".$this->host." port=".$this->port." password=".$this->clave." user=".$this->user." dbname=".$this->db." ") or die("ERROR DE CONEXION");  /*verifica los dartos y muestra */
		// return $this->url;
	}

	function destruir() {

		pg_close($this->url);

	}

}


?>
