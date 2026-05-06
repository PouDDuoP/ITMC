<?php

class Departamento
{
  private $id;
  // private $nombre_empleado;
  //nombre_empleaado no debe ir aca ya que en departamento lo que almacena es el nombre de departamento y para lectura de codigo confunde que una variable
  //que recibe el numbre de un departamento se llame nombre_empleado
  private $nombre_departamento;
  private $descripcion;
  private $status;
  private $pgconn;

  // function inicializar($id,""$nombre_empleado"",$descripcion,$status,$pgconn)
  function inicializar($id,$nombre_departamento,$descripcion,$status,$pgconn)
  {
    $this->id = $id;
    // ""$this->nombre_empleado"" = ""$nombre_empleado"";
    $this->nombre_departamento = $nombre_departamento;
    $this->descripcion = $descripcion;
    $this->status = $status;
    $this->pgconn = $pgconn;
  }
  function consultar_departamento($pgconn)
  {

    /*
    // esta mal la parte de la consulta por tres razones.
    // pirmera estas llamando a una tabla dapartamen0 supongo que se te fue el "0"
    // segunda limit con el limit la consulta quedaria de la siguiente manera: "SELECT * FROM itmc.departament0 limit"
      // como puedes ver el limit no tiene ningun valor y por ende va a tildar error y recuerda que no nesecitas el limit para esta consulta
      // NOTA : cuando realizas una consulta con un limit queda de la siguiente manera: "SELECT * FROM <esquema.tabla> limit <cantidad que queires ver>"
      //                                                                       ejemplo: "SELECT * FROM itmc.departamento limit 10"
    // por ultimo pero no menos importante caundo cierras variables simepre recuerda cerrar con un punto y coma ";" ejemplo $MyVaraible = 9;
    // el cerrar con el ";" no solo aplica para variables tambine para funciones propias de php o respuestas de metodos de calses ejemplo: return $MyVaraible;

    $querySQL = "SELECT * FROM itmc.departament0
    limit"
    */

    $querySQL = "SELECT * FROM itmc.departamento";
		$operacion = pg_query($pgconn,$querySQL) or die ("Consulta errónea: ".pg_last_error());
		return $operacion;
  }

//Recuerda siempr cerrar las llaves luego de abrirlas porque sino la consulta no procede y te generara un error
}

  ?>
